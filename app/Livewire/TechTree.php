<?php

namespace App\Livewire;

use App\Technologies\TechnologyType;
use Illuminate\Support\Collection;
use Livewire\Component;

class TechTree extends Component
{
    /**
     * @param Collection<int, TechnologyType> $eraTechs
     * @return int
     */
    public static function eraWidth(Collection $eraTechs): int
    {
        $minX = $eraTechs->min(fn($tech) => $tech->xy()->x);
        $maxX = $eraTechs->max(fn($tech) => $tech->xy()->x);
        return $maxX - $minX + 1;
    }

    public function render()
    {
        $knownTechs = TechnologyType::all()
            ->filter(fn(TechnologyType $tech) => $tech->xy()->x < 29)
            ->each(fn(TechnologyType $tech) => $tech->research = $tech->cost())
            ->keyBy(fn(TechnologyType $tech) => $tech->slug());

        return view('livewire.tech-tree', ['knownTechs' => $knownTechs]);
    }
}
