@php
    use App\Enums\Domain;use App\Enums\Surface;
    use App\Enums\Feature;
    use App\Models\Hex;
    $hexSize = match ($zoomLevel) {
        1 => 25,
        default => 100,
    };
    $hexHeight = $hexSize * 0.905;
    $hexWidth = $hexSize * 0.78;

    $hexes = collect();

    foreach ($map->regions as $region) {
        if ($zoomLevel < 3) {
            $hexes->push($region);
        } else {
            if ($region->x >= $x - 4 &&
                $region->x <= $x + 4 &&
                $region->y >= $y - 2 &&
                $region->y <= $y + 2
            ) {
                foreach ($region->hexes as $hex) {
                    $hexes->push($hex);
                }
             }
        }
    }

    $mapWidth = match($zoomLevel) {
        1 => $map->width * 1.17,
        2 => $map->width * 1.004,
        3  => 9 * 3 * 1.02,
     };
    $mapHeight = match($zoomLevel) {
        1 => $map->height * 1.235,
        2 => $map->height * 1.007,
        3 => 5 * 3 * 1.02,
     };
@endphp

<div id="hexmap-{{ $map->id }}" class="hexmap relative" wire:loading.class="animate-pulse">
    <style>
        .hexmap {
            background: #333;
            width: {{ $mapWidth * $hexWidth }}px;
            height: {{ $mapHeight * $hexHeight }}px;
            padding: 10px;
        }

        .hex-row {
            margin-left: {{ $hexWidth * 0.346 }}px;
            margin-bottom: -{{ $hexWidth * 0.346 / 5 }}px;
        }

        .hex {
        }

        .hex:hover {
            opacity: 0.8;
        }

        .hex.even {
        }

        .hex.odd {
            top: {{ $hexHeight * 0.48 }}px;
        }

        .hex-feature {
            width: 100%;
            height: 100%;
            position: absolute;
            opacity: 0.5;
            background-size: cover;
        }

        .hex-unit {
            width: 54%;
            height: 61%;
            top: 12%;
            left: 17%;
            position: absolute;
            border-radius: 100%;
            border-width: 12px;
            border-style: solid;
            background-size: cover;
        }

        .hex {
            display: inline-block;
            position: relative;
            margin-left: -{{ $hexWidth * 0.34 }}px;
            background-size: cover;

            --radius: 0px;
            --size: {{ $hexSize }}px;
            --f: 5;

            width: var(--size);
            height: auto;
            aspect-ratio: 1.155;
            object-fit: cover;

            --cg: #0000, #000 1deg 119deg, #0000 120deg;
            --rad: radial-gradient(farthest-side, #000 99%, #0000 101%);
            --s: calc(2 * var(--radius)) calc(2 * var(--radius));

            -webkit-mask: var(--rad) left calc(0.25 * var(--size) - 0.4 * var(--radius)) top 0    / var(--s),
            var(--rad) right calc(0.25 * var(--size) - 0.4 * var(--radius)) top 0    / var(--s),
            var(--rad) left calc(0.25 * var(--size) - 0.4 * var(--radius)) bottom 0 / var(--s),
            var(--rad) right calc(0.25 * var(--size) - 0.4 * var(--radius)) bottom 0 / var(--s),
            var(--rad) left calc(0.15 * var(--radius)) top 50%  / var(--s),
            var(--rad) right calc(0.15 * var(--radius)) top 50%  / var(--s),
            conic-gradient(from 30deg at left calc(-0.3 * var(--radius)) top 50%, var(--cg)) left calc(0.3 * var(--radius)) top 50% /50% calc(100% - 0.8 * var(--radius)),
            conic-gradient(from -150deg at right calc(-0.3 * var(--radius)) top 50%, var(--cg)) right calc(0.3 * var(--radius)) top 50% /50% calc(100% - 0.8 * var(--radius)),
            linear-gradient(#000 0 0) center/calc(45% - 1.1 * var(--radius));
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            cursor: pointer;
            transition: 0.1s linear;
        }

        @foreach(Surface::cases() as $surface)
            .dummy {
        }

        .hex-surface-{{ $surface->cssClass() }}             {
            background-image: {!! $surface->cssBackground() !!};
        }

        @endforeach
        @foreach(Feature::cases() as $feature)
            .dummy {
        }

        .hex-feature-{{ $feature->cssClass() }}             {
            background-image: {!! $feature->cssBackground() !!};
        }

        @endforeach

        .hex-feature-air {
            background-image: {!! Domain::Air->cssBackground() !!};
        }

        .hex-feature-land {
            opacity: 0.25;
            background-image: {!! Domain::Land->cssBackground() !!};
        }

        .hex-feature-water {
            opacity: 0.25;
            background-image: {!! Domain::Water->cssBackground() !!};
        }

        .hex-elevation-hill {
            opacity: 0.25;
            background-image: {!! Domain::elevationCssBackground(1) !!};
        }

        .hex-elevation-mountain {
            opacity: 0.5;
            background-image: {!! Domain::elevationCssBackground(5) !!};
        }
    </style>

    @foreach($hexes->sortBy(['x', 'y'])->groupBy('y') as $hexes)
        <div class="hex-row">
            @foreach($hexes as $hex)
                @php /** @var Hex $hex */ @endphp
                <div @class([
                        'hex',
                        "hex-elevation-{$hex->elevation}",
                        "hex-surface-{$hex->surface->cssClass()}",
                        'odd' => $hex->x % 2 === 1,
                    ])
                     title="{{ implode(', ', array_filter([
                        $hex->surface->name,
                        $hex->feature?->name,
                        ($hex->elevation * 100) . 'm',
                    ])) }}"
                     wire:click="setCoords({{ round($hex->x / ($zoomLevel < 3 ? 1 : 3)) }}, {{ round($hex->y / ($zoomLevel < 3 ? 1 : 3)) }})"
                >
                    @if($hex->feature)
                        <div class="hex-feature hex-feature-{{ $hex->feature?->cssClass() }}"></div>
                    @else
                        <div class="hex-feature hex-feature-{{ $hex->domain->cssClass() }}"></div>
                    @endif
                    @if($hex->elevation >= 5)
                        <div class="hex-feature hex-elevation-mountain"></div>
                    @elseif($hex->elevation >= 1)
                        <div class="hex-feature hex-elevation-hill"></div>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach


    @if($zoomLevel === 3)
        <div class="absolute top-1/2 p-3 left-0 bg-gray-600 cursor-pointer text-2xl"
             wire:click="setCoords({{ $x - 2 }}, {{ $y }})">
            <i class="fa fa-chevron-left"></i>
        </div>
        <div class="absolute top-1/2 p-3 right-0 bg-gray-600 cursor-pointer text-2xl"
             wire:click="setCoords({{ $x + 2 }}, {{ $y }})">
            <i class="fa fa-chevron-right"></i>
        </div>
        @if($x > 0)
            <div class="absolute top-0 p-3 right-0 bg-gray-600 cursor-pointer text-2xl"
                 wire:click="setCoords({{ $x + 1 }}, {{ $y - 1 }})">
                <i class="fa fa-chevron-up rotate-45"></i>
            </div>
            <div class="absolute top-0 p-3 left-1/2 bg-gray-600 cursor-pointer text-2xl"
                 wire:click="setCoords({{ $x }}, {{ $y - 1 }})">
                <i class="fa fa-chevron-up"></i>
            </div>
            <div class="absolute top-0 p-3 left-0 bg-gray-600 cursor-pointer text-2xl"
                 wire:click="setCoords({{ $x - 1 }}, {{ $y - 1 }})">
                <i class="fa fa-chevron-left rotate-45"></i>
            </div>
        @endif
        @if($x < $map->height * 3)
            <div class="absolute bottom-0 p-3 left-0 bg-gray-600 cursor-pointer text-2xl"
                 wire:click="setCoords({{ $x - 1 }}, {{ $y + 1 }})">
                <i class="fa fa-chevron-down rotate-45"></i>
            </div>
            <div class="absolute bottom-0 p-3 left-1/2 bg-gray-600 cursor-pointer text-2xl"
                 wire:click="setCoords({{ $x }}, {{ $y + 1 }})">
                <i class="fa fa-chevron-down"></i>
            </div>
            <div class="absolute bottom-0 p-3 right-0 bg-gray-600 cursor-pointer text-2xl"
                 wire:click="setCoords({{ $x + 1 }}, {{ $y + 1 }})">
                <i class="fa fa-chevron-right rotate-45"></i>
            </div>
        @endif
    @endif

    <div class="fixed top-1/3 left-0 bg-gray-800 rounded-r-lg overflow-hidden cursor-pointer">
        <div class="p-2 @if($zoomLevel === 1) bg-gray-500 @endif border-b" wire:click="setZoom(1)">
            <i class="fa fa-globe fa-fw"></i>
            <span class="hidden">World</span>
        </div>
        <div class="p-2 @if($zoomLevel === 2) bg-gray-500 @endif border-b" wire:click="setZoom(2)">
            <i class="fa fa-map fa-fw"></i>
            <span class="hidden">Region</span>
        </div>
        <div class="p-2 @if($zoomLevel === 3) bg-gray-500 @endif" wire:click="setZoom(3)">
            <i class="fa fa-table-cells fa-fw"></i>
            <span class="hidden">Local</span>
        </div>
    </div>
</div>
