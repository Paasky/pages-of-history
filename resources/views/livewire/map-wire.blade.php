@php
    use App\Enums\Domain;use App\Enums\Surface;
    use App\Enums\Feature;
    use App\Models\Hex;
    $hexSize = 100;
    $hexHeight = $hexSize * 0.905;
    $hexWidth = $hexSize * 0.78;
@endphp

<div id="hexmap-{{ $map->id }}" class="hexmap">
    <style>
        .hexmap {
            background: #999;
            width: {{ ($map->width * 1.058) * $hexWidth }}px;
            height: {{ ($map->height * 1.07) * $hexHeight }}px;
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

    @foreach($map->regions->sortBy(['x', 'y'])->groupBy('y') as $hexes)
        <div class="hex-row">
            @foreach($hexes as $hex)
                @php /** @var Hex $hex */ @endphp
                <div @class([
                        'hex',
                        "hex-elevation-{$hex->elevation}",
                        "hex-surface-{$hex->surface->cssClass()}",
                        'odd' => $hex->x % 2 === 1,
                    ])
                     tooltip="{{ implode(', ', array_filter([
                        $hex->surface->name,
                        $hex->feature?->name,
                        ($hex->elevation * 100) . 'm',
                    ])) }}"
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
</div>
