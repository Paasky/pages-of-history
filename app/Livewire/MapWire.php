<?php

namespace App\Livewire;

use App\Models\Map;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MapWire extends Component
{
    public Map $map;

    public function mount(): void
    {
        $this->map = Map::firstOrFail();
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
}
