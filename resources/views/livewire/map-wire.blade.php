<div id="hexmap-{{ $map->id }}" class="hexmap">
    <style>
        .hexmap {
            background: #ddd;
            width: {{ $map->width * 96 }}px;
            height: {{ $map->height * 96 }}px;
        }

        .hex {
            float: left;
            margin-right: -26px;
            margin-bottom: -50px;
        }
        .hex:hover {
            opacity: 0.9;
        }
        .hex:hover:before {
            content: attr(tooltip);
            position: absolute;
            background: #ccc;
            padding: 2px 5px;
            text-align: center;
            width: 110px;
        }
        .hex .left {
            float: left;
            width: 0;
            border-right: 30px solid #999;
            border-top: 52px solid transparent;
            border-bottom: 52px solid transparent;
        }
        .hex .middle {
            float: left;
            width: 60px;
            height: 104px;
            background: #999;
        }
        .hex .right {
            float: left;
            width: 0;
            border-left: 30px solid #999;
            border-top: 52px solid transparent;
            border-bottom: 52px solid transparent;
        }
        .hex-row {
            clear: left;
        }
        .hex.odd {
            margin-top: 53px;
        }
    </style>
    <style>
        @foreach(\App\Enums\HexSurface::cases() as $surface)
            .hexmap {}
            .hex-surface-{{ $surface->cssClass() }} .left,
            .hex-surface-{{ $surface->cssClass() }} .right {
                border-right-color: {{ $surface->cssColor() }};
                border-left-color: {{ $surface->cssColor() }};
            }
            .hex-surface-{{ $surface->cssClass() }} .middle {
                background: {{ $surface->cssColor() }};
            }
        @endforeach
    </style>
    @foreach($map->hexes->sortBy(['x', 'y'])->groupBy('y') as $hexes)
        <div class="hex-row">
            @foreach($hexes as $hex)
                @php /** @var \App\Models\Hex $hex */ @endphp
                <div @class([
                        'hex',
                        "hex-elevation-{$hex->elevation}",
                        "hex-surface-{$hex->surface->cssClass()}",
                        "hex-feature-{$hex->feature?->cssClass()}" => $hex->feature,
                        'odd' => $hex->x % 2,
                    ])
                    tooltip="{{ implode(', ', array_filter([
                        $hex->surface->name,
                        $hex->feature?->name,
                        ($hex->elevation * 100) . 'm',
                    ])) }}"
                >
                    <div class="left"></div>
                    <div class="middle"></div>
                    <div class="right"></div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
