<?php

namespace App\Livewire;

use App\Yields\YieldModifiersFor;
use Livewire\Component;

class YieldModifierForWire extends Component
{
    protected YieldModifiersFor $yieldModifierFor;
    protected bool $showForName = false;
    protected bool $showYieldName = false;

    public function mount(YieldModifiersFor $yieldModifierFor, bool $showForName = true, $showYieldName = true): void
    {
        $this->yieldModifierFor = $yieldModifierFor;
        $this->showForName = $showForName;
        $this->showYieldName = $showYieldName;
    }

    public function render()
    {
        return view(
            'livewire.yield-modifier-for-wire',
            [
                'yieldModifierFor' => $this->yieldModifierFor,
                'showForName' => $this->showForName,
                'showYieldName' => $this->showYieldName,
            ]
        );
    }
}
