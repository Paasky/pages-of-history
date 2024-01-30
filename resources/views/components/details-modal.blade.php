@php
    /** @var GameConcept $gameConcept */
use App\GameConcept;use App\Yields\YieldModifier;$scroll = $gameConcept->yieldModifiers()->count()
        + $gameConcept->allows()->count()
        + $gameConcept->requires()->count()
        > 6 ? 'overflow-y-scroll max-h-60' : '';
@endphp
<div
    class="details-modal pl-1 rounded-b-lg hidden text-sm absolute bg-white border-4 border-t-0 border-gray-700 z-10 {{ $scroll }}"
    style="margin-top: -0.25rem;"
>
    <div class="{{ $gameConcept->typeSlug() }}">
        @if($gameConcept->icon())
            <i class="fa-solid {{ $gameConcept->icon() }}"></i>
        @endif
        {{ $gameConcept->name() }}
        @if($gameConcept->category())
            @include('components.game-concept-tag', [
                'gameConcept' => $gameConcept->category(),
                'showDetails' => false,
                'append' => $gameConcept->typeName(),
            ])
        @endif
    </div>
    @foreach($gameConcept->yieldModifiers() as $yieldModifier)
        @if($yieldModifier instanceof YieldModifier)
            @include('components.yield-modifier', ['yieldModifier' => $yieldModifier])
        @else
            <hr class="my-1">
            @include('components.yield-modifier-for', ['yieldModifiersFor' => $yieldModifier])
        @endif
    @endforeach

    @if($gameConcept->allows()->isNotEmpty())
        <hr class="my-1">
    @endif
    @foreach($gameConcept->allows() as $required)
        @include('components.game-concept-tag', [
            'gameConcept' => $required,
            'showDetails' => false,
            'prepend' => __('Allows'),
        ])
    @endforeach

    @if($gameConcept->requires()->isNotEmpty())
        <hr class="my-1">
    @endif
    @foreach($gameConcept->requires() as $required)
        @include('components.game-concept-tag', [
            'gameConcept' => $required,
            'showDetails' => false,
            'prepend' => __('Requires'),
        ])
    @endforeach
</div>
