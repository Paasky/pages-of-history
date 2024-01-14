<div class="tag tag-yield tag-{{ $yieldModifierFor->for->typeSlug() }} clickable">
    <div class="yield-for">
        @if(method_exists($yieldModifierFor->for, 'icon'))
            <i class="fa-solid {{ $yieldModifierFor->for->icon() }}"></i>
        @endif
        @if($showForName)
            {{ $yieldModifierFor->for->name }}
        @endif
    </div>
    <div class="yield-for-modifiers">
        @foreach($yieldModifierFor->modifiers as $modifier)
            <livewire:yield-modifier-wire :yield-modifier="$modifier" :show-name="$showYieldName"/>
        @endforeach
    </div>
</div>
