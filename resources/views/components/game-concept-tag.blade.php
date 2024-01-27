@php
    /** @var \App\GameConcept $gameConcept */
    /** @var bool|null $showDetails */
    /** @var bool|null $showFullName */
    /** @var string|null $prepend */
    /** @var string|null $append */
    $dataForInit = $gameConcept->dataForInit();
    $onClick = "@click.stop=\"\$dispatch('show-game-concept', {class: '{$dataForInit['class']}', id: '{$dataForInit['id']}'})\"";
@endphp
<span class="tag {{ $gameConcept->typeSlug() }} clickable" {!! $onClick !!}>
    {{ $prepend ?? '' }}
    @if($gameConcept->icon())
        <i class="fa-solid {{ $gameConcept->icon() }}"></i>
    @endif
    {{ ($showFullName ?? true) ? $gameConcept->name() : $gameConcept->shortName() }}
    {{ $append ?? '' }}

    @if(($showDetails ?? true) && $gameConcept->hasDetails())
        @include('components.details-modal', ['gameConcept' => $gameConcept])
    @endif
</span>
