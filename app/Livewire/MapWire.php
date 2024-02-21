<?php

namespace App\Livewire;

use App\Models\Map;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MapWire extends Component
{
    public Map $map;

    public int $zoomLevel = 1;
    public ?int $x = 12;
    public ?int $y = 12;

    public function mount(): void
    {
        $this->map = Map::orderByDesc('id')->firstOrFail();
    }

    public function placeholder(): string
    {
        return <<<'HTML'
            <div class="animate-pulse text-2xl text-gray-300 text-center tracking-wide">
                <br><br><br><br><br>
                Loading Map...
            </div>
        HTML;
    }

    public function render(): View
    {
        return view('livewire.map-wire');
    }

    public function setCoords(int $x, int $y): void
    {
        $this->x = max(0, min($this->map->width - 1, $x));
        $this->y = max(0, min($this->map->height - 1, $y));
        $this->zoomLevel = 3;
    }

    public function setZoom(int $zoomLevel): void
    {
        $this->zoomLevel = $zoomLevel;
    }
}
