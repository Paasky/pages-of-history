@php
    /** @var \App\Yields\YieldModifiersFor $yieldModifiersFor */
    /** @var bool|null $showForName */
    /** @var bool|null $showYieldName */
@endphp
<div class="tag {{ $yieldModifiersFor->for->typeSlug() }} clickable"
     @click.stop="$dispatch('show-game-concept', {{ json_encode($yieldModifiersFor->for->dataForInit()) }})"
>
    <div class="yield-for">
        @if($yieldModifiersFor->for->icon())
            <i class="fa-solid {{ $yieldModifiersFor->for->icon() }}"></i>
        @endif
        @if($showForName ?? true)
            {{ $yieldModifiersFor->for->name }}
        @endif
    </div>
    <div class="yield-for-modifiers">
        @foreach($yieldModifiersFor->modifiers as $yieldModifier)
            @include('components.yield-modifier', ['yieldModifier' => $yieldModifier, 'showName' => $showYieldName ?? true])
        @endforeach
    </div>
</div>
