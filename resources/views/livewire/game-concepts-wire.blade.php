<div id="game-concepts-wire" style="display: none;" x-data="{show: @entangle('showModal')}" x-show="show">
    <style>
        #game-concepts-wire {
            position: absolute;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.5);
            width: 100vw;
            height: 100vh;
        }

        #game-concepts {
            position: absolute;
            top: 5vh;
            left: 5vw;
            width: 90vw;
            height: 90vh;
            overflow: hidden;
            background: #fafafa;
            border: #444 solid 0.25em;
            border-radius: 1em;
        }

        #game-concepts-title {
            background: #444;
            color: #fff;
        }

        #game-concepts h2 {
            margin: 0.25em;
            display: inline-block;
        }

        #game-concepts h3 {
            margin: 0.5em 0 0.5em 1px;
            padding: 0.25em;
        }

        #game-concepts ul {
            list-style: none;
            padding-left: 0;
            padding-right: 1em;
        }

        #game-concepts li {
            display: inline-block;
            width: 100%;
        }

        #game-concepts li.clickable {
            margin: 0.5em 0.25em;
            padding: 0.25em;
        }

        #game-concepts-index {
            max-width: 33%;
            width: 15em;
            margin-right: 2em;
            float: left;
            overflow-y: scroll;
            overflow-x: hidden;
            height: 96%;
            border-right: #000 solid 1px;
            border-top: #000 solid 1px;
        }

        #game-concepts-index .tag {
            width: 100%;
        }

        #game-concepts-content {
            float: right;
            max-height: 90%;
            max-width: 70%;
            padding-right: 5%;
            overflow-y: scroll;
        }

        .close {
            float: right;
            background: #d00;
            color: #fff;
            height: 2.5em;
            width: 2.5em;
            text-align: center;
            line-height: 2.25em;
        }

        #game-concept-details {
            width: 30%;
            float: right;
        }

        #game-concept-details > span {
            width: 100%;
        }

        #game-concept-description {
            width: 60%;
            float: left;
        }

        #game-concepts-content h2 {
            float: left;
            width: 100%;
            margin: 0.5em 0 1em;
        }

        #game-concepts-content h3 {
            float: left;
            width: 100%;
            margin: 1em 0 0.5em;
        }
    </style>
    <div id="game-concepts">
        <div id="game-concepts-title">
            <h2>Game Concepts</h2>
            <div class="clickable close" @click="show=false"><i class="fa fa-x"></i></div>
        </div>
        <div id="game-concepts-index">
            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\UnitArmorCategory::cases(),
                 'title' => __('Armor Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\UnitArmor\UnitArmorType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Armor'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\BuildingCategory::cases(),
                 'title' => __('Building Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Buildings\BuildingType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Buildings'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\ImprovementCategory::cases(),
                 'title' => __('Improvement Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Improvements\ImprovementType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Improvements'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\UnitPlatformCategory::cases(),
                 'title' => __('Platform Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\UnitPlatforms\UnitPlatformType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Platforms'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\ResourceCategory::cases(),
                 'title' => __('Resource Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Resources\ResourceType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Resources'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\TechnologyEra::cases(),
                 'title' => __('Eras'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Technologies\TechnologyType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Technologies'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\Enums\UnitEquipmentCategory::cases(),
                 'title' => __('Equipment Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => \App\UnitEquipment\UnitEquipmentType::all()->sortBy(fn (\App\GameConcept $b) => $b->name()),
                 'title' => __('Equipment'),
            ])
        </div>
        <div id="game-concepts-content">
            @if($current)
                <h2>{{ $current->name() }} ({{ $current->typeName() }})</h2>
                <div id="game-concept-description">
                    Stretch kitty scratches couch bad kitty catch eat throw up catch eat throw up bad birds. Chase red
                    laser dot knock dish off table head butt cant eat out of my own dish or why dog in house? i'm the
                    sole ruler of this home and its inhabitants smelly, stupid dogs, inferior furballs time for
                    night-hunt, human freakout but where is my slave? I'm getting hungry but tweeting a baseball
                    instantly break out into full speed gallop across the house for no reason sleeping in the box. Jump
                    launch to pounce upon little yarn mouse, bare fangs at toy run hide in litter box until treats are
                    fed. Eat grass, throw it back up. Eat the fat cats food meow meow pee in shoe. To pet a cat, rub its
                    belly, endure blood and agony, quietly weep, keep rubbing belly man running from cops stops to pet
                    cats, goes to jail. Slap owner's face at 5am until human fills food dish ask to go outside and ask
                    to come inside and ask to go outside and ask to come inside cat slap dog in face. Drink water out of
                    the faucet take a big fluffing crap ðŸ’© or plays league of legends spread kitty litter all over
                    house. Why can't i catch that stupid red dot human give me attention meow. Gate keepers of hell
                    weigh eight pounds but take up a full-size bed for carefully drink from water glass and then spill
                    it everywhere and proceed to lick the puddle. Thug cat eat a plant, kill a hand. Is good you
                    understand your place in my world purr purr purr until owner pets why owner not pet me hiss scratch
                    meow sleeping in the box pet me pet me don't pet me. I bet my nine lives on you-oooo-ooo-hooo prow??
                    ew dog you drink from the toilet, yum yum warm milk hotter pls, ouch too hot for do doodoo in the
                    litter-box, clickityclack on the piano, be frumpygrumpy, and dont wait for the storm to pass, dance
                    in the rain or scratch me now! stop scratching me!.
                </div>
                <div id="game-concept-details">
                    @if($current->category())
                        <h3>Category</h3>
                        @include('components.game-concept-tag', ['gameConcept' => $current->category()])
                    @endif

                    @if($current->yieldModifiers()->isNotEmpty())
                        <h3>Modifiers</h3>
                        @foreach($current->yieldModifiers() as $yieldModifier)
                            @if($yieldModifier instanceof \App\Yields\YieldModifier)
                                @include('components.yield-modifier', ['yieldModifier' => $yieldModifier])
                            @else
                                    @include('components.yield-modifier-for', ['yieldModifiersFor' => $yieldModifier])
                            @endif
                        @endforeach
                    @endif

                    @if($current->allows()->isNotEmpty())
                        <h3>Allows</h3>
                        @foreach($current->allows() as $allow)
                            @include('components.game-concept-tag', ['gameConcept' => $allow])
                        @endforeach
                    @endif

                    @if($current->requires()->isNotEmpty())
                        <h3>Requires</h3>
                        @foreach($current->requires() as $require)
                            @include('components.game-concept-tag', ['gameConcept' => $require])
                        @endforeach
                    @endif

                    @if($current->items()->isNotEmpty())
                        <h3>Items</h3>
                        @foreach($current->items() as $item)
                            @include('components.game-concept-tag', ['gameConcept' => $item])
                        @endforeach
                    @endif

                        @if($current->upgradesTo())
                            <h3>Upgrades To</h3>
                            @include('components.game-concept-tag', ['gameConcept' => $current->upgradesTo()])
                        @endif

                        @if($current->upgradesFrom()->isNotEmpty())
                            <h3>Upgrades From</h3>
                            @foreach($current->upgradesFrom() as $item)
                                @include('components.game-concept-tag', ['gameConcept' => $item])
                            @endforeach
                        @endif
                </div>
            @else
                <h2>No Game Concept Selected</h2>
            @endif
        </div>
    </div>
</div>
