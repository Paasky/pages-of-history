@php use App\Enums\HexSurface; @endphp
@php use App\Enums\HexFeature; @endphp
@php use App\Models\Hex; @endphp
<div id="hexmap-{{ $map->id }}" class="hexmap">
    <style>
        .hexmap {
            background: #999;
            width: {{ $map->width * 154 }}px;
            height: {{ $map->height * 181 }}px;
            padding: 10px;
        }

        .hex-row {
            line-height: 14px;
            margin-left: 54px;
        }

        .hex {
            display: inline-block;
            position: relative;
            margin-left: -53px;
            background-size: cover;
        }

        .hex:hover {
            opacity: 0.8;
        }

        .hex.even {
        }

        .hex.odd {
            top: 87px;
        }

        .hex-feature {
            width: 76%;
            height: 76%;
            top: 12%;
            left: 12%;
            position: relative;
            border-radius: 33%;
            opacity: 0.5;
            background-size: cover;
        }

        @property --radius {
            syntax: '<length>';
            inherits: true;
            initial-value: 0;
        }

        .hex {
            --radius: 0px;
            --size: 200px;
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
    </style>
    <style>
        @foreach(HexSurface::cases() as $surface)
            .dummy {
        }

        .hex-surface-{{ $surface->cssClass() }}       {
            background-image: {!! $surface->cssBackground() !!};
        }

        @endforeach
        @foreach(HexFeature::cases() as $feature)
            .dummy {
        }

        .hex-feature-{{ $feature->cssClass() }}       {
            background-image: {!! $feature->cssBackground() !!};
        }
        @endforeach
    </style>
    @foreach($map->hexes->sortBy(['x', 'y'])->groupBy('y') as $hexes)
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
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach
</div>
