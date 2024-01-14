<?php

namespace App\Livewire;

use App\AbstractType;
use App\Enums\BuildingCategory;
use App\Enums\ImprovementCategory;
use App\Enums\ResourceCategory;
use Livewire\Component;

class TypeTagWire extends Component
{
    protected AbstractType|BuildingCategory|ImprovementCategory|ResourceCategory $instance;
    protected bool $showDetails;
    protected bool $showFullName;
    protected string $prepend;
    protected string $append;

    public function mount(
        AbstractType|BuildingCategory|ImprovementCategory|ResourceCategory $instance,
        bool                                                               $showDetails = true,
        bool                                                               $showFullName = false,
        string                                                             $prepend = '',
        string                                                             $append = '',
    ): void
    {
        $this->instance = $instance;
        $this->showDetails = $showDetails;
        $this->showFullName = $showFullName;
        $this->prepend = $prepend;
        $this->append = $append;
    }

    public function render()
    {
        return view(
            'livewire.type-tag-wire',
            [
                'instance' => $this->instance,
                'showDetails' => $this->showDetails,
                'showFullName' => $this->showFullName,
                'prepend' => $this->prepend,
                'append' => $this->append,
            ]
        );
    }
}
