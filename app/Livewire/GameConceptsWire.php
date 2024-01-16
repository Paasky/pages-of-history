<?php

namespace App\Livewire;

use App\GameConcept;
use Livewire\Attributes\On;
use Livewire\Component;

class GameConceptsWire extends Component
{
    /** @var string[]|GameConcept[] */
    public array $breadcrumbs = [];
    public bool $showModal = false;
    protected ?GameConcept $current = null;

    #[On('show-game-concept')]
    public function show(string $class, string|int $id = null): void
    {
        $this->showModal = true;
        $this->current = match (true) {
            method_exists($class, 'get') => $class::get(),
            method_exists($class, 'from') => $class::from($id),
            default => throw new \Exception("Unknown class $class")
        };
    }

    public function render()
    {
        return view('livewire.game-concepts-wire', ['current' => $this->current]);
    }
}
