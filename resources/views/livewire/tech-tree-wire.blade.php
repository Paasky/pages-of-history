<div id="tech-tree-wire">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <script src="https://kit.fontawesome.com/e51c679d33.js" crossorigin="anonymous"></script>
    <script src="/anseki-leader-line-6c26a9d/leader-line.min.js"></script>
    <style>
        body {
            font-family: 'Figtree', sans-serif;
            max-width: 100vw;
        }

        #tech-tree-wire {
            overflow-x: scroll;
        }

        #tech-tree {
            background-color: #fff2d7;
            border-radius: 10px;
            position: relative;
            width: {{ $techTree::widthEm() }}em;
            height: {{ $techTree::heightEm() }}em;
        }

        #tech-tree-arrows {
            width: 100%;
            height: 100%;
            display: inline-block;
            position: absolute;
        }

        .tech-tree-era {
            display: inline-block;
            background: #e3dfc8;
            position: absolute;
            top: {{ $techTree::$eraTopPadding }}em;
            border-radius: 10px;
        }

        .tech-tree-era-title {
            padding: 0.25em 0.5em;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }

        .tech {
            display: inline-block;
            position: absolute;
            border-radius: 5px;
            width: {{ $techTree::$techWidth }}em;
            height: {{ $techTree::$techHeight }}em;
            background: #fff;
            white-space: nowrap;
        }

        .title {
            padding: 0.1em 0.25em;
            border-radius: 5px 5px 0 0;
        }

        .title .tag {
            float: none;
            margin-top: 0.2em;
            font-style: italic;
            margin-left: 1em;
        }

        .tech-details {
            padding: 0.1em 0.25em;
        }

        .tech-details .title {
            margin-bottom: 0.5em;
        }

        .tag {
            padding: 0 0.2em;
            display: inline-block;
            line-height: 1.5em;
            float: left;
            margin: 0 0.2em 0.2em 0;
            border-radius: 3px;
        }

        .tag-building {
            background: rgb(233, 233, 233);
        }

        .tag-era {
            background: #444;
            color: #fff;
        }

        .tag-improvement {
            background: rgb(233 255 233);
        }

        .tag-resource {
            background: rgb(255, 255, 211);
        }

        .tag-technology {
            background: rgb(233, 233, 255);
        }

        .tag-unit {
            background: rgb(255, 233, 233);
        }

        .yield-modifier {
            display: inline-block;
            float: left;
            padding-left: 0.5em;
        }

        .clickable {
            cursor: pointer;
            box-shadow: rgba(0, 0, 0, 0.2) 1px 1px 2px 1px;
            transition: box-shadow 0.2s ease-out;
        }

        .clickable:not(:has(.clickable:hover)):hover,
        .clickable:not(:has(.clickable)):hover {
            box-shadow: none;
        }

        .details-modal {
            display: none;
            font-size: 0.75em;
        }

        .tag:hover .details-modal, .details-modal.open {
            display: block;
        }

        .details-modal {
            position: absolute;
            background: #fff;
            border: 2px solid #999;
            border-radius: 0 0 10px 10px;
            z-index: 10;
        }

        .details-modal > div, .details-modal > span {
            display: block;
            float: none;
        }

        .details-modal > .clickable {
            padding: 0 0.5em;
            margin: 0.5em;
        }

        .details-modal .yield-modifier {
            display: block;
            float: none;
            padding-left: 0.5em;
        }
    </style>

    <div id="tech-tree" width="{{ $techTree::widthEm() }}em">
        <div id="tech-tree-eras">
            @foreach($techTree::techs()->groupBy(fn (\App\Technologies\TechnologyType $tech) => $tech->era()->name) as $era => $eraTechs)
                @php
                    $era = \App\Enums\TechnologyEra::from($era);
                    [$eraLeft, $eraWidth] = $techTree::eraLeftAndWidthEm($eraTechs);
                @endphp
                <div id="era-{{ $era->slug() }}" class="tech-tree-era"
                     style="left: {{ $eraLeft }}em;
                                width: {{ $eraWidth }}em;
                                height: {{ $techTree::eraHeightEm() }}em;"
                >
                    <div class="tech-tree-era-title tag-era">{{ $era->name() }}</div>
                </div>
            @endforeach
        </div>

        <div id="tech-tree-arrows"></div>

        <div id="tech-tree-techs">
            @foreach($techTree::techs() as $tech)
                <div id="tech-{{ $tech->slug() }}"
                     class="tech clickable"
                     style="left: {{ $techTree::techLeftEm($tech) }}em;
                                top: {{ $techTree::techTopEm($tech) }}em;"
                >
                    <div class="title tag-technology">
                        {{ $tech->name() }} ({{ $tech->cost() }})
                    </div>
                    <div class="tech-details">
                        @foreach($tech->buildings() as $building)
                            <livewire:type-tag-wire :instance="$building"/>
                        @endforeach
                        @foreach($tech->improvements() as $improvement)
                            <livewire:type-tag-wire :instance="$improvement"/>
                        @endforeach
                        @foreach($tech->resources() as $resource)
                            <livewire:type-tag-wire :instance="$resource"/>
                        @endforeach
                        @foreach($tech->yieldModifiersFors() as $yieldModifierFor)
                            <livewire:yield-modifier-for-wire :yield-modifier-for="$yieldModifierFor"
                                                              :show-yield-name="false">
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        @foreach($techTree::techs() as $tech)
        @foreach($tech->requires() as $requireTech)

        new LeaderLine(
            document.getElementById('tech-{{ $requireTech->slug() }}'),
            document.getElementById('tech-{{ $tech->slug() }}'),
            {
                color: '#444',
                size: 2,
                endPlug: 'arrow3',
                endPlugSize: 2,
                startSocketGravity: {{ ($tech->xy()->x - $requireTech->xy()->x) ** 2 * 50 }},
                endSocketGravity: {{ ($tech->xy()->x - $requireTech->xy()->x) ** 2 * 50 }},
            }
        );

        @endforeach
        @endforeach

        const containerRect = document.getElementById('tech-tree-wire').getBoundingClientRect();
        const techArrows = document.getElementById('tech-tree-arrows');
        techArrows.style.left = '-' + containerRect.left + 'px';
        techArrows.style.top = '-' + containerRect.top + 'px';
        for (const line of document.getElementsByClassName('leader-line')) {
            techArrows.appendChild(line);
        }
    </script>
</div>
