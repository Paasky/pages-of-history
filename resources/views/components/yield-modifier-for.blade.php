@php use App\Yields\YieldModifiersFor; @endphp
@php use App\GameConcept; @endphp
@php use App\Yields\YieldModifiersAgainst; @endphp
@php
    /** @var YieldModifiersFor|YieldModifiersAgainst $yieldModifiersFor */
    /** @var bool|null $showForName */
    /** @var bool|null $showYieldName */

    /** @var GameConcept $gameConcept */
    /** @var bool|null $showDetails */
    /** @var bool|null $showFullName */
    /** @var string|null $prepend */
    /** @var string|null $append */
@endphp
<div class=" inline-block p-1 m-1 border rounded-md border-gray-500 yield-modifier-for">
    @foreach($yieldModifiersFor->modifiers as $yieldModifier)
        @include('components.yield-modifier', ['yieldModifier' => $yieldModifier, 'showName' => $showYieldName ?? true])
    @endforeach
    <br>
    @if($yieldModifiersFor instanceof YieldModifiersAgainst)
        vs
    @else
        for
    @endif
    @foreach($yieldModifiersFor->for as $for)
        @include('components.game-concept-tag', [
            'gameConcept' => $for,
            'showName' => $showForName ?? true,
            'showDetails' => false,
        ])
    @endforeach
</div>
