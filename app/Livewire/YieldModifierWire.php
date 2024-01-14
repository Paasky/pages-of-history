<?php

namespace App\Livewire;

use App\Yields\YieldModifier;
use Livewire\Component;

class YieldModifierWire extends Component
{
    protected YieldModifier $yieldModifier;
    protected bool $showName = true;

    public function mount(YieldModifier $yieldModifier, bool $showName = true): void
    {
        $this->yieldModifier = $yieldModifier;
        $this->showName = $showName;
    }

    public function render()
    {
        return view(
            'livewire.yield-modifier-wire',
            ['yieldModifier' => $this->yieldModifier, 'showName' => $this->showName]
        );
    }
}
