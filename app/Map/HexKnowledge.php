<?php

namespace App\Map;

use App\Enums\Feature;
use App\Improvements\ImprovementType;
use App\Models\Player;
use App\Resources\ResourceType;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class HexKnowledge implements Arrayable
{
    public function __construct(
        protected Player          $player,
        protected int             $turn,
        protected Feature         $feature,
        protected ResourceType    $resource,
        protected int             $resourceAmount,
        protected ImprovementType $improvement,
        protected int             $improvementHealth,
        protected Collection      $events,
    )
    {
    }

    public static function fromArray(array $data, Player $player = null): self
    {
        $player = $player ?: Player::findOrFail($data['player']);
        return new self(
            $player,
            $data['turn'],
            $data['feature'],
            $data['resource'],
            $data['resourceAmount'],
            $data['improvement'],
            $data['improvementHealth'],
            collect($data['events'])->map(
                fn(HexEvent|array $event) => is_array($event) ? HexEvent::fromArray($event) : $event
            ),
        );
    }

    public function toArray(): array
    {
        return [
            'player' => $this->player->id,
            'turn' => $this->turn,
            'feature' => $this->feature,
            'resource' => $this->resource,
            'resource_amount' => $this->resourceAmount,
            'improvement' => $this->improvement,
            'improvement_health' => $this->improvementHealth,
            'events' => $this->events->map(fn(HexEvent $event) => $event->toArray())->all(),
        ];
    }
}
