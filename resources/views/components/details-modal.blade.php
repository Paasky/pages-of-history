@php
    /** @var \App\GameConcept $gameConcept */
@endphp
<div class="details-modal">
    <div class="title {{ $gameConcept->typeSlug() }}">
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
        @if($yieldModifier instanceof \App\Yields\YieldModifier)
            @include('components.yield-modifier', ['yieldModifier' => $yieldModifier])
        @else
            @include('components.yield-modifier-for', ['yieldModifiersFor' => $yieldModifier])
        @endif
    @endforeach
    @foreach($gameConcept->allows() as $required)
        @include('components.game-concept-tag', [
            'gameConcept' => $required,
            'showDetails' => false,
            'prepend' => __('Allows'),
        ])
    @endforeach
    @if($gameConcept->allows()->isNotEmpty() & $gameConcept->requires()->isNotEmpty())
        <hr/>
    @endif
    @foreach($gameConcept->requires() as $required)
        @include('components.game-concept-tag', [
            'gameConcept' => $required,
            'showDetails' => false,
            'prepend' => __('Requires'),
        ])
    @endforeach
</div>
