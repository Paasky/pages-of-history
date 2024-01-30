<?php

namespace App\Livewire;

use App\GameConcept;
use Livewire\Attributes\On;
use Livewire\Component;

class GameConcepts extends Component
{
    protected ?GameConcept $current = null;

    #[On('show-game-concept')]
    public function show(string $class, string|int $id = null): void
    {
        // Fix any wonky escapes that swam through
        $class = str_replace('\\\\', '\\', $class);

        $this->current = match (true) {
            method_exists($class, 'get') => $class::get(),
            method_exists($class, 'from') => $class::from($id),
            default => throw new \Exception("Unknown class $class")
        };
    }

    public function render()
    {
        $this->dispatch('open-modal', 'game-concepts');
        return view('livewire.game-concepts', ['current' => $this->current]);
    }
}
