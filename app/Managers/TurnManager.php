<?php

namespace App\Managers;

use App\Buildings\BuildingType;
use App\Enums\YieldType;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Player;
use App\Models\UnitDesign;
use App\Yields\YieldModifier;

class TurnManager
{
    public function processPlayerTurn(Player $player): void
    {
        foreach ($player->turn_yield_modifiers as $yieldModifier) {
            if (!$yieldModifier->amount) {
                continue;
            }
            if ($yieldModifier->amount < 0) {
                $player->yield_stock->takeUpTo($yieldModifier->type, abs($yieldModifier->amount));
                continue;
            }

            $player->yield_stock->put($yieldModifier->type, $yieldModifier->amount);
        }

        // Process Research
        $researchTech = $player->technologies->where('is_researching', true)->first();
        $turnResearch = $player->yield_stock->amount(YieldType::Science);
        if ($turnResearch >= $researchTech->research_remaining) {
            $player->yield_stock->take(YieldType::Science, $researchTech->research_remaining);
            $researchTech->is_researching = false;
            $researchTech->is_known = true;
            $researchTech->research = $researchTech->type->cost();
            // todo Notify that research is complete
        } else {
            $player->yield_stock->take(YieldType::Science, $turnResearch);
            $researchTech->research = $researchTech->research + $turnResearch;
        }
        $researchTech->save();

        foreach ($player->cities as $city) {
            $this->processCityTurn($city);
        }
    }

    public function processCityTurn(City $city): void
    {
        foreach ($city->yield_modifiers as $yieldModifier) {
            if (!$yieldModifier->amount) {
                continue;
            }
            if ($yieldModifier->amount < 0) {
                $city->yield_stock->takeUpTo($yieldModifier->type, abs($yieldModifier->amount));
                continue;
            }

            $city->yield_stock->put($yieldModifier->type, $yieldModifier->amount);
        }

        // Process Growth
        if ($city->yield_stock->has(YieldType::Food, 20)) {
            $city->yield_stock->take(YieldType::Food, 20);
            $city->citizens()->create([
                'culture_id' => $city->citizens->random()->culture,
                'religion_id' => $city->citizens->random()->religion,
                'desire_yield' => YieldType::casesFor(new Citizen)->random(),
            ]);
            // todo Notify that citizen has been born
        }

        // Process Production
        $turnProduction = $city->yield_stock->takeAll(YieldType::Production);
        $producingNow = $city->production_queue->producingNow();
        $producingNowCost = $producingNow instanceof UnitDesign
            ? $producingNow->cost
            : $producingNow->cost();
        $productionRemaining = $producingNowCost - $city->production_queue->currentProgress();

        if ($turnProduction >= $productionRemaining) {
            $city->yield_stock->take(YieldType::Production, $productionRemaining);
            $city->production_queue->completeFirstItem();

            if ($producingNow instanceof UnitDesign) {
                $city->homeForUnits()->create([
                    'hex_id' => $city->hex_id,
                    'player_id' => $city->player_id,
                    'unit_design_id' => $producingNow->id,
                    'type' => $producingNow->type,
                    'health' => 100,
                    'moves_remaining' => $producingNow->moves,
                ]);
                // todo Notify that building is complete
            }

            if ($producingNow instanceof BuildingType) {
                $city->hex->buildings()->create([
                    'type' => $producingNow,
                    'health' => 100,
                ]);
                // todo Notify that building is complete
            }
        } else {
            $city->yield_stock->take(YieldType::Production, $turnProduction);
            $city->production_queue->addProgress($turnProduction);
        }
        $city->save();
    }
}
