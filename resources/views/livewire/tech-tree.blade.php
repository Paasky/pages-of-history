@php
    use App\Enums\TechnologyEra;
    use App\Technologies\TechnologyType;
    use App\LiveWire\TechTree;

    use App\GameConcept;
    use App\Yields\YieldModifier;
@endphp
<x-modal name="tech-tree" title="{{ __('Tech Tree') }}" icon="fa-flask" maxWidth="7xl">
    @php
        $techHeight = 7;
        $techHeightGutter = -3;
        $techHeightWithGutter = $techHeight + $techHeightGutter;
        $techWidth = 18;
        $techWidthGutter = 4;
        $techWidthWithGutter = $techWidth + $techWidthGutter;
        $prevEraX = 1;
        $drawArrowContainer = true;
    @endphp

    <script src="/anseki-leader-line-6c26a9d/leader-line.min.js"></script>
    <script>

        let techTreeResizeTimer = null;
        let isTechTreeArrowsDrawing = false;

        function drawTechArrows(force = false) {
            if (!force && document.getElementsByClassName('leader-line').length) {
                return;
            }

            if (techTreeResizeTimer) {
                clearTimeout(techTreeResizeTimer);
            }

            while (document.getElementsByClassName('leader-line').length) {
                for (const line of document.getElementsByClassName('leader-line')) {
                    line.parentNode.removeChild(line);
                }
            }

            techTreeResizeTimer = setTimeout(() => drawTechArrowsNow(), force ? 2000 : 100);
        }

        addEventListener("resize", () => drawTechArrows(true));

        function drawTechArrowsNow() {
            if (isTechTreeArrowsDrawing) {
                return;
            }
            isTechTreeArrowsDrawing = true;

            if (window.getComputedStyle(document.getElementById('tech-tree')).display === 'none') {
                isTechTreeArrowsDrawing = false;
                return;
            }

            @foreach(TechnologyType::all() as $tech)
            @foreach($tech->requires() as $requireTech)

            new LeaderLine(
                document.getElementById('tech-{{ $requireTech->slug() }}'),
                document.getElementById('tech-{{ $tech->slug() }}'),
                {
                    color: '#bbb',
                    size: 2,
                    endPlug: 'arrow3',
                    endPlugSize: 2,
                    startSocketGravity: {{ ($tech->xy()->x - $requireTech->xy()->x) ** 2 * 50 }},
                    endSocketGravity: {{ ($tech->xy()->x - $requireTech->xy()->x) ** 2 * 50 }},
                }
            );

            @endforeach
            @endforeach

            // Move lines from body into the tech tree
            const containerRect = document.getElementById('era-neolithic').getBoundingClientRect();
            const techArrows = document.getElementById('tech-tree-arrows');
            techArrows.style.left = '-' + containerRect.left + 'px';
            techArrows.style.top = 'calc(-' + containerRect.top + 'px - 2rem)';
            for (const line of document.getElementsByClassName('leader-line')) {
                techArrows.appendChild(line);
            }
            isTechTreeArrowsDrawing = false;
        }
    </script>
    <div class="flex overflow-x-scroll">
        @foreach(TechnologyEra::cases() as $era)
            @php
                $techs = $era->technologies()->sortBy(fn (TechnologyType $tech) => $tech->order());
                $eraWidth = TechTree::eraWidth($techs);
                $currentEraMaxX = 0;
            @endphp
            <div id="era-{{ $era->slug() }}" class="m-2 mb-16 mr-10 bg-gray-700 rounded-xl"
                 style="min-width: {{ $eraWidth * $techWidthWithGutter - $techWidthGutter + 1 }}rem; min-height: {{ 10.5 * $techHeightWithGutter + 1 }}rem"
            >
                <div class="p-2 tracking-wide uppercase whitespace-nowrap rounded-t-xl text-center">
                    {{ $era->name() }} {{ __('Era') }}
                </div>
                <div class="relative">
                    @if($drawArrowContainer)
                        <div id="tech-tree-arrows" style="position: absolute;"></div>
                        @php $drawArrowContainer = false; @endphp
                    @endif
                    @foreach($techs as $tech)
                        @php
                            $currentEraMaxX = max($currentEraMaxX, $tech->xy()->x);
                            $background = isset($knownTechs[$tech->slug()]) ? 'bg-gray-600' : 'bg-gray-500';
                            foreach ($tech->requires() as $require) {
                                if ($require instanceof TechnologyType && !isset($knownTechs[$require->slug()])) {
                                    $background = 'bg-gray-800';
                                }
                            }
                        @endphp
                        <div id="tech-{{ $tech->slug() }}" class="m-2 rounded-md absolute clickable {{ $background }}"
                             wire:loading.class="animate-pulse"
                             style="
                                 width: {{ $techWidth }}rem;
                                 height: {{ $techHeight }}rem;
                                 top: {{ ($tech->xy()->y - 1) * $techHeightWithGutter }}rem;
                                 left: {{ ($tech->xy()->x - $prevEraX) * $techWidthWithGutter }}rem;
                             "
                             @click.stop="openModal('game-concepts'); $dispatch('show-game-concept', {{ json_encode($tech->dataForInit()) }})"
                        >
                            <div class="px-2 technology whitespace-nowrap rounded-t-md">
                                {{ $tech->name() }}
                                <span class="float-right">({{ $tech->known }}/{{ $tech->cost() }} <i
                                        class="fa {{$tech->icon() }}"></i>)</span>
                            </div>
                            <div class="text-sm p-1">
                                @foreach($tech->allows()->filter(fn (GameConcept $allow) => !$allow instanceof TechnologyType) as $gameConcept)
                                    @include('components.game-concept-tag', ['gameConcept' => $gameConcept, 'showFullName' => false])
                                @endforeach
                                @foreach($tech->yieldModifiers() as $yieldModifier)
                                    @if($yieldModifier instanceof YieldModifier)
                                        @include('components.yield-modifier', ['yieldModifier' => $yieldModifier])
                                    @else
                                        @include('components.yield-modifier-for', ['yieldModifiersFor' => $yieldModifier, 'showYieldName' => false])
                                    @endif
                                @endforeach
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
