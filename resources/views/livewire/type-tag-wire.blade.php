<span class="tag tag-{{ $instance->typeSlug() }} clickable">
    {{ $prepend }}
    @if($instance->icon())
        <i class="fa-solid {{ $instance->icon() }}"></i>
    @endif
    {{ $showFullName ? $instance->name() : $instance->shortName() }}
    {{ $append }}

    @if($showDetails)
        <div class="details-modal">
            <div class="title tag-{{ $instance->typeSlug() }}">
                @if($instance->icon())
                    <i class="fa-solid {{ $instance->icon() }}"></i>
                @endif
                {{ $instance->name() }}
                @if(method_exists($instance, 'category') && $instance->category())
                    <livewire:type-tag-wire
                        :instance="$instance->category()"
                        :show-details="false"
                        :show-full-name="true"
                        :append="$instance->typeSlug()"
                    />
                @endif
            </div>
            @if(method_exists($instance, 'yieldModifiers'))
                @foreach($instance->yieldModifiers() as $yieldModifier)
                    <div class="tag tag-yield">
                        <livewire:yield-modifier-wire :yield-modifier="$yieldModifier"/>
                    </div>
                @endforeach
            @endif
            @if(method_exists($instance, 'yieldModifiersFors'))
                @foreach($instance->yieldModifiersFors() as $yieldModifierFor)
                    <livewire:yield-modifier-for-wire :yield-modifier-for="$yieldModifierFor"/>
                @endforeach
            @endif
            @if(method_exists($instance, 'improvementCategory') && $instance->improvementCategory())
                <livewire:type-tag-wire
                    :instance="$instance->improvementCategory()"
                    :type="'improvement'"
                    :show-details="false"
                    :show-full-name="true"
                    :show-requires="true"
                    :prepend="'Requires'"
                    :append="'Improvement'"
                />
            @endif
            @if(method_exists($instance, 'resources'))
                @foreach($instance->resources() as $count => $resource)
                    <livewire:type-tag-wire
                        :instance="$resource"
                        :type="'resource'"
                        :show-details="false"
                        :show-full-name="true"
                        :show-requires="true"
                        :prepend="'Requires'"
                        :append="'Resource'"
                    />
                @endforeach
            @endif
            @if(method_exists($instance, 'technology') && $instance->technology())
                <livewire:type-tag-wire
                    :instance="$instance->technology()"
                    :type="'technology'"
                    :show-details="false"
                    :show-full-name="true"
                    :show-requires="true"
                    :prepend="'Requires'"
                />
            @endif
        </div>
    @endif
</span>
