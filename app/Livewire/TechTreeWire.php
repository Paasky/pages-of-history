<?php

namespace App\Livewire;

use App\Technologies\TechTree;
use Livewire\Component;

class TechTreeWire extends Component
{
    public function render()
    {
        return view('livewire.tech-tree-wire', ['techTree' => new TechTree()]);
    }
}
