@php use App\GameConcept; @endphp
@php
    /** @var GameConcept $gameConcept */
    /** @var string $title */
@endphp
<div class="p-2" x-data="{show: false}">
    <div class="text-md clickable" x-on:click="show = !show">{{ $title }}</div>
    <ul x-show="show" style="display: none;">
        @foreach($gameConcepts as $gameConcept)
            <div class="m-1" wire:click="$current = $gameConcept">
                @include('components.game-concept-tag', [
                    'gameConcept' => $gameConcept,
                    'showDetails' => false,
                ])
            </div>
        @endforeach
    </ul>
</div>
