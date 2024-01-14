<div class="yield-modifier" style="color: {{ $yieldModifier->color }}">
    {{ $yieldModifier->effect }}
    <i class="fa-solid {{ $yieldModifier->type->icon() }}"></i>
    @if($showName)
        {{ $yieldModifier->type->name }}
    @endif
</div>
