@php use App\Models\UnitDesign; @endphp
@php use App\Enums\YieldType; @endphp
@php
    /** @var UnitDesign $design */
@endphp
<div
    class="flex h-8 w-28 border border-white bg-gray-600 rounded-full overflow-hidden cursor-pointer hover:bg-white hover:text-gray-600 transition-all"
    title="{{ $design->name }} (Strength {{ $design->yield_modifiers->where('type', YieldType::Strength)->first()?->amount ?: 0 }})"
>
    <div class="bg-white text-gray-600 rounded-full w-8 h-8 relative overflow-hidden text-xs" style="min-width:2rem">
        @if($design->armor)
            <a style="left:8%; bottom:38%" class="absolute text-xs fa-solid fa-fw {{ $design->platform->icon() }}"></a>
            <a style="right:8%; bottom:38%"
               class="absolute text-xs fa-solid fa-fw {{ $design->equipment->icon() }}"></a>
            <a style="left:31%; bottom:5%" class="absolute text-xs fa-solid fa-fw {{ $design->armor?->icon() }}"></a>
        @else
            <a style="left:0; bottom:20%" class="absolute text-sm fa-solid fa-fw {{ $design->platform->icon() }}"></a>
            <a style="right:0; bottom:20%" class="absolute text-sm fa-solid fa-fw {{ $design->equipment->icon() }}"></a>
        @endif
    </div>
    <div class="overflow-hidden whitespace-nowrap leading-8 ml-0.5 mr-1 text-xs">{{ $design->name }}</div>
</div>
