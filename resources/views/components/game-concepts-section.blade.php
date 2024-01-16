@php
    /** @var \App\GameConcept $gameConcept */
    /** @var string $title */
@endphp
<div class="game-concept-section" x-data="{show: false}">
    <h3 class="clickable" x-on:click="show = !show">{{ $title }}</h3>
    <ul x-show="show" style="display: none;">
        @foreach($gameConcepts as $gameConcept)
            <li wire:click="$current = $gameConcept">
                @include('components.game-concept-tag', [
                    'gameConcept' => $gameConcept,
                    'showDetails' => false,
                ])
            </li>
        @endforeach
    </ul>
</div>
