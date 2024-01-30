@php use App\Enums\TechnologyEra; @endphp
@php use App\Technologies\TechnologyType; @endphp
@php use App\Technologies\TechTree; @endphp
<x-modal name="tech-tree" title="{{ __('Tech Tree') }}" icon="fa-flask" maxWidth="7xl" show="true">
    @php
        $techHeight = 4;
        $techHeightGutter = 0;
        $techHeightWithGutter = $techHeight + $techHeightGutter;
        $techWidth = 14;
        $techWidthGutter = 4;
        $techWidthWithGutter = $techWidth + $techWidthGutter;
        $prevEraX = 1;
    @endphp
    <div class="flex overflow-x-scroll transition" wire:loading.class="opacity-25">
        @foreach(TechnologyEra::cases() as $era)
            @php
                $techs = $era->technologies()->sortBy(fn (TechnologyType $tech) => $tech->order());
                $eraWidth = TechTree::eraWidth($techs);
                $currentEraMaxX = 0;
            @endphp
            <div class="m-2 mb-4 mr-10 bg-gray-700 rounded-xl"
                 style="min-width: {{ $eraWidth * $techWidthWithGutter - $techWidthGutter + 1 }}rem; min-height: {{ 10 * $techHeightWithGutter + 1 }}rem"
            >
                <div
                    class="p-2 tracking-wide uppercase whitespace-nowrap rounded-t-xl text-center">{{ $era->name() }} {{ __('Era') }}</div>
                <div class="relative">
                    @foreach($techs as $tech)
                        @php
                            $currentEraMaxX = max($currentEraMaxX, $tech->xy()->x);
                        @endphp
                        <div class="m-2 bg-gray-600 rounded-md absolute clickable"
                             style="width: {{ $techWidth }}rem; top: {{ ($tech->xy()->y - 1) * $techHeightWithGutter }}rem; left: {{ ($tech->xy()->x - $prevEraX) * $techWidthWithGutter }}rem;"
                             @click.stop="openModal('game-concepts'); $dispatch('show-game-concept', {{ json_encode($tech->dataForInit()) }})"
                        >
                            <div class="px-2 technology whitespace-nowrap rounded-t-md">
                                <i class="fa {{$tech->icon() }}"></i>
                                {{ $tech->name() }}
                            </div>
                            <div style="height: {{ $techHeight }}rem">

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @php
                $prevEraX = $currentEraMaxX + 1;
            @endphp
        @endforeach
    </div>
</x-modal>
