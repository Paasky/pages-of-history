<x-modal name="unit-designer" title="{{ __('Unit Designer') }}" icon="fa-screwdriver-wrench" maxWidth="4xl">
    <div class="transition sm:p-2" wire:loading.class="opacity-50">
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

            <div class="grid grid-cols-3 justify-items-center pt-0 sm:p-4 border-2 m-4 rounded-xl">
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

            <div class="grid grid-cols-2 p-4 gap-4">
                <x-text-input name="design_name" placeholder="Design Name"/>
                <x-primary-button class="justify-center">Save</x-primary-button>
            </div>
        @endif
    </div>
</x-modal>
