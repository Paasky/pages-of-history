@php
    use App\Enums\BuildingCategory;
    use App\Buildings\BuildingType;
    use App\Enums\CultureTrait;use App\Enums\CultureVice;use App\Enums\CultureVirtue;use App\Enums\Domain;use App\Enums\Feature;use App\Enums\ImprovementCategory;
    use App\Enums\ReligionTenet;use App\Enums\Surface;use App\Enums\YieldType;use App\Improvements\ImprovementType;
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
                'gameConcepts' => Domain::cases(),
                 'title' => __('Domains'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => Surface::cases(),
                 'title' => __('Surfaces'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => Feature::cases(),
                 'title' => __('Features'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => CultureTrait::cases(),
                 'title' => __('Culture Traits'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => CultureVice::cases(),
                 'title' => __('Culture Vices'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => CultureVirtue::cases(),
                 'title' => __('Culture Virtues'),
            ])

            @include('components.game-concepts-section', [
                'gameConcepts' => ReligionTenet::cases(),
                 'title' => __('Religion Tenets'),
            ])

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

            @include('components.game-concepts-section', [
                'gameConcepts' => YieldType::cases(),
                 'title' => __('Yield Types'),
            ])
        </div>
        <div class="col-span-7 pl-2 p-4 transition" wire:loading.class="opacity-25">
            @if($current)
                <div class="text-2xl mb-4">
                    {{ $current->name() }} ({{ $current->typeName() }})
                </div>
                <div class="">
                    <img class="float-right w-1/2 p-2 ml-4 mb-1" src="/images/{{ $current->slug() }}.jpeg"
                         alt="{{ $current->slug() }}"/>
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
                    <p class="text-justify">
                        {!! nl2br(e($current->description())) !!}
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
