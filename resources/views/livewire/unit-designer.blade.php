@php use App\Yields\YieldModifier; @endphp
<x-modal name="unit-designer" title="{{ __('Unit Designer') }}" icon="fa-screwdriver-wrench" maxWidth="4xl">
    <div class="sm:p-2 transition" wire:loading.class="opacity-25">
        @if($platform)
            @php
                $maxWeight = (int) $platform?->maxWeight;
                $equipmentWeight = (int) $equipment?->weight;
                $armorWeight = (int) $armor?->weight;
                $totalWeight = $equipmentWeight + $armorWeight;
                $maxArmorSlots = (int) match (true) {
                    $equipment && !$equipment->canHaveArmor() => 0,
                    default => $platform?->armorSlots,
                };
            @endphp

            <div class="pt-0 sm:p-4 border-2 m-4 rounded-xl">
                <div class="grid grid-cols-3 justify-items-center">
                    <div @class([
                        'text-orange-600' => !$armor && $platform?->armorSlots && $equipment?->canHaveArmor() && $totalWeight >= $maxWeight
                    ])>
                        <i class="fa-solid fa-weight-hanging"></i>
                        Weight
                        {{ $totalWeight }}/{{ $maxWeight }}
                    </div>
                    <div>
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                        Equipment
                        {{ $equipmentWeight }}/{{ (int) $platform?->equipmentSlots }}
                    </div>
                    <div>
                        <i class="fa-solid fa-shield-halved"></i>
                        Armor
                        {{ $armorWeight }}/{{ $maxArmorSlots }}
                    </div>
                </div>
                <div class="grid grid-cols-4 justify-items-center items-center">
                    @php
                        $yieldModifiers = YieldModifier::mergeModifiers(
                            $platform->yieldModifiers()
                                ->merge($equipment?->yieldModifiers() ?: collect())
                                ->merge($armor?->yieldModifiers() ?: collect())
                        );
                    @endphp
                    @foreach($yieldModifiers as $yieldModifier)
                        @if($yieldModifier instanceof YieldModifier)
                            @include('components.yield-modifier', ['yieldModifier' => $yieldModifier])
                        @else
                            @include('components.yield-modifier-for', ['yieldModifiersFor' => $yieldModifier])
                        @endif
                    @endforeach
                </div>
            </div>
        @endif

        @include('livewire.unit-designer-section', [
            'title' => $platformTitle,
            'titleIcon' => 'fa-inbox',
            'setter' => 'setPlatform',
            'current' => $platform,
            'itemsPerCategory' => $platformItems,
        ])

        <hr class="mt-2">

        @include('livewire.unit-designer-section', [
            'title' => $equipmentTitle,
            'setter' => 'setEquipment',
            'titleIcon' => 'fa-screwdriver-wrench',
            'current' => $equipment,
            'itemsPerCategory' => $equipmentItems,
        ])

        <hr class="mt-2">

        @include('livewire.unit-designer-section', [
            'title' => $armorTitle,
            'setter' => 'setArmor',
            'titleIcon' => 'fa-shield-halved',
            'current' => $armor,
            'itemsPerCategory' => $armorItems,
        ])

        @if($platform && $equipment && ($armorItems->isEmpty() || $armor))
            <hr class="mt-2">

            <form class="grid grid-cols-2 p-4 gap-4" wire:submit="save">
                <x-text-input placeholder="{{ $namePlaceholder }}" wire:model="name"/>
                <x-primary-button class="justify-center">Save</x-primary-button>
            </form>
        @endif
    </div>
</x-modal>
