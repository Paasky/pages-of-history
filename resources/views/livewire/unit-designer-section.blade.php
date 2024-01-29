@php
    use App\Enums\GameConceptEnum;
    use App\AbstractType;
    use App\UnitArmor\UnitArmorType;
    use App\UnitEquipment\UnitEquipmentType;
    use App\UnitPlatforms\UnitPlatformType;
    use Illuminate\Support\Collection;
        /** @var string $title */
        /** @var string $titleIcon */
        /** @var string $setter */
        /** @var UnitPlatformType|UnitEquipmentType|UnitArmorType $current */
        /** @var null|Collection|UnitPlatformType[][][]|UnitEquipmentType[][][]|UnitArmorType[][][] $itemsPerCategory */
@endphp
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-2">
        <div class="text-xl w-full">
            @if($current)
                <i class="fa fa-solid {{ $current->icon() }}"></i>
                {{ $current->name() }} ({{ $current->category()->name() }}) {{ $title }}
                <span class="border border-gray-600 rounded-lg p-1 clickable"
                      wire:click="{{ $setter }}(null)"
                >
                    Change
                </span>
            @else
                <i class="fa fa-solid {{ $titleIcon }}"></i>
                <span class="italic">{{ $title }}</span>
            @endif
        </div>

        @if(!$current && $itemsPerCategory?->isNotEmpty())
            <div class="mt-6 flex flex-wrap">
                @foreach($itemsPerCategory as $categoryData)
                    @php
                        /** @var null|GameConceptEnum $category */
                        $category = $categoryData['category'];
                        $items = $categoryData['items'];
                    @endphp

                    <div class="border border-gray-700 rounded-lg m-2 flex-{{ min($items->count(), 3) }} grow">
                        <div class="bg-gray-700 rounded-t-lg p-2 mb-2">
                            <i class="fa-solid {{ $category->icon() }}"></i> {{ $category->name() }}
                        </div>
                        <div class="flex flex-wrap p-2 pt-1">
                            @foreach($items as $item)
                                <div
                                    class="border border-gray-600 rounded-lg h-8 w-48 p-1 m-1 text-center grow clickable"
                                    @class([
                                       'bg-gray-700' => $current?->slug() === $item->slug(),
                                    ])
                                    wire:click="{{ $setter }}('{{ $item->slug() }}')"
                                >
                                    <i class="fa-solid {{ $item->icon() }}"></i> {{ $item->name() }}
                                    @if (!$item instanceof UnitPlatformType)
                                        <span class="text-sm text-gray-500 ml-1">
                                        <i class="fa-solid fa-weight-hanging"></i> {{ $item->weight }}
                                    </span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
