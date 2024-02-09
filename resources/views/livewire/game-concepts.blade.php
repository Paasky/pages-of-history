@php
    use App\Enums\BuildingCategory;
    use App\Buildings\BuildingType;
    use App\Enums\ImprovementCategory;
    use App\Improvements\ImprovementType;
    use App\Enums\ResourceCategory;
    use App\Resources\ResourceType;
    use App\Enums\TechnologyEra;
    use App\Technologies\TechnologyType;
    use App\Enums\UnitPlatformCategory;
    use App\UnitPlatforms\UnitPlatformType;
    use App\Enums\UnitEquipmentCategory;
    use App\UnitEquipment\UnitEquipmentType;
    use App\Enums\UnitArmorCategory;
    use App\UnitArmor\UnitArmorType;
    use App\GameConcept;
    use App\Yields\YieldModifier;
@endphp
<x-modal name="game-concepts" title="{{ __('Game Concepts') }}" icon="fa-circle-question" maxWidth="6xl">
    <style>
        .game-concept-info > hr:last-child {
            display: none;
        }
    </style>
    <div class="grid grid-cols-10">
        <div class="col-span-3 border-r-2 border-gray-700 mr-4">
            @include('components.game-concepts-section', [
                'gameConcepts' => BuildingCategory::cases(),
                 'title' => __('Building Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => BuildingType::all()->sortBy(fn (BuildingType $b) => $b->name()),
                 'title' => __('Buildings'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => ImprovementCategory::cases(),
                 'title' => __('Improvement Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => ImprovementType::all()->sortBy(fn (ImprovementType $b) => $b->name()),
                 'title' => __('Improvements'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => ResourceCategory::cases(),
                 'title' => __('Resource Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => ResourceType::all()->sortBy(fn (ResourceType $b) => $b->name()),
                 'title' => __('Resources'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => TechnologyEra::cases(),
                 'title' => __('Eras'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => TechnologyType::all()->sortBy(fn (TechnologyType $b) => $b->name()),
                 'title' => __('Technologies'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => UnitPlatformCategory::cases(),
                 'title' => __('Unit Platform Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => UnitPlatformType::all()->sortBy(fn (UnitPlatformType $b) => $b->name()),
                 'title' => __('Unit Platforms'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => UnitEquipmentCategory::cases(),
                 'title' => __('Unit Equipment Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => UnitEquipmentType::all()->sortBy(fn (UnitEquipmentType $b) => $b->name()),
                 'title' => __('Unit Equipment'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => UnitArmorCategory::cases(),
                 'title' => __('Unit Armor Categories'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => UnitArmorType::all()->sortBy(fn (UnitArmorType $b) => $b->name()),
                 'title' => __('Unit Armors'),
            ])
        </div>
        <div class="col-span-7 pl-2 p-4 transition" wire:loading.class="opacity-25">
            @if($current)
                <div class="text-2xl mb-4">
                    {{ $current->name() }} ({{ $current->typeName() }})
                </div>
                <div class="">
                    <div class="game-concept-info float-right inline-block w-1/2 bg-gray-700 p-2 ml-4 mb-1 rounded-xl">
                        @if($current->category())
                            <div class="text-lg">Category</div>
                            @include('components.game-concept-tag', ['gameConcept' => $current->category()])
                            <hr class="border-gray-600 my-2">
                        @endif

                        @if($current->yieldModifiers()->isNotEmpty())
                            <div class="text-lg">Modifiers</div>
                            @foreach($current->yieldModifiers() as $yieldModifier)
                                @if($yieldModifier instanceof YieldModifier)
                                    @include('components.yield-modifier', ['yieldModifier' => $yieldModifier])
                                @else
                                    @include('components.yield-modifier-for', ['yieldModifiersFor' => $yieldModifier])
                                @endif
                            @endforeach
                            <hr class="border-gray-600 my-2">
                        @endif

                        @if($current->allows()->isNotEmpty())
                            <div class="text-lg">Allows</div>
                            @foreach($current->allows() as $allow)
                                @include('components.game-concept-tag', ['gameConcept' => $allow])
                            @endforeach
                            <hr class="border-gray-600 my-2">
                        @endif

                        @if($current->requires()->isNotEmpty())
                            <div class="text-lg">Requires</div>
                            @foreach($current->requires() as $require)
                                @include('components.game-concept-tag', ['gameConcept' => $require])
                            @endforeach
                            <hr class="border-gray-600 my-2">
                        @endif

                        @if($current->items()->isNotEmpty())
                            <div class="text-lg">Items</div>
                            @foreach($current->items() as $item)
                                @include('components.game-concept-tag', ['gameConcept' => $item])
                            @endforeach
                            <hr class="border-gray-600 my-2">
                        @endif

                        @if($current->upgradesTo())
                            <div class="text-lg">Upgrades To</div>
                            @include('components.game-concept-tag', ['gameConcept' => $current->upgradesTo()])
                            <hr class="border-gray-600 my-2">
                        @endif

                        @if($current->upgradesFrom()->isNotEmpty())
                            <div class="text-lg">Upgrades From</div>
                            @foreach($current->upgradesFrom() as $item)
                                @include('components.game-concept-tag', ['gameConcept' => $item])
                            @endforeach
                            <hr class="border-gray-600 my-2">
                        @endif
                    </div>
                    <p>
                        Stretch kitty scratches couch bad kitty catch eat throw up catch eat throw up bad birds. Chase
                        red
                        laser dot knock dish off table head butt cant eat out of my own dish or why dog in house? i'm
                        the
                        sole ruler of this home and its inhabitants smelly, stupid dogs, inferior furballs time for
                        night-hunt, human freakout but where is my slave? I'm getting hungry but tweeting a baseball
                        instantly break out into full speed gallop across the house for no reason sleeping in the box.
                        Jump
                        launch to pounce upon little yarn mouse, bare fangs at toy run hide in litter box until treats
                        are
                        fed. Eat grass, throw it back up. Eat the fat cats food meow meow pee in shoe. To pet a cat, rub
                        its
                        belly, endure blood and agony, quietly weep, keep rubbing belly man running from cops stops to
                        pet
                        cats, goes to jail. Slap owner's face at 5am until human fills food dish ask to go outside and
                        ask
                        to come inside and ask to go outside and ask to come inside cat slap dog in face. Drink water
                        out of
                        the faucet take a big fluffing crap ðŸ’© or plays league of legends spread kitty litter all over
                        house. Why can't i catch that stupid red dot human give me attention meow. Gate keepers of hell
                        weigh eight pounds but take up a full-size bed for carefully drink from water glass and then
                        spill
                        it everywhere and proceed to lick the puddle. Thug cat eat a plant, kill a hand. Is good you
                        understand your place in my world purr purr purr until owner pets why owner not pet me hiss
                        scratch
                        meow sleeping in the box pet me pet me don't pet me. I bet my nine lives on you-oooo-ooo-hooo
                        prow??
                        ew dog you drink from the toilet, yum yum warm milk hotter pls, ouch too hot for do doodoo in
                        the
                        litter-box, clickityclack on the piano, be frumpygrumpy, and dont wait for the storm to pass,
                        dance
                        in the rain or scratch me now! stop scratching me!.
                    </p>
                </div>
            @else
                <div class="text-center text-2xl text-gray-500 font-bold pt-60">
                    Select a Concept from the left
                </div>
            @endif
        </div>
    </div>
</x-modal>
