@php use App\Yields\YieldModifier; @endphp
@php
    /** @var YieldModifier $yieldModifier */
    /** @var bool|null $showName */
@endphp
<div class="yield-modifier" style="color: {{ $yieldModifier->color }}">
    {{ $yieldModifier->effect }}
    <i class="fa-solid {{ $yieldModifier->type->icon() }}"></i>
    @if($showName ?? true)
        {{ $yieldModifier->type->name() }}
    @endif
</div>
