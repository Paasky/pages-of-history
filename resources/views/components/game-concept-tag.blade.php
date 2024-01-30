@php
    /** @var GameConcept $gameConcept */
    /** @var bool|null $showDetails */
    /** @var bool|null $showName */
    /** @var bool|null $showFullName */
    /** @var string|null $prepend */
    /** @var string|null $append */
    use App\GameConcept;$dataForInit = $gameConcept->dataForInit();
    $onClick = "@click.stop=\"\$dispatch('show-game-concept', {class: '{$dataForInit['class']}', id: '{$dataForInit['id']}'})\"";
@endphp
<span
    class="tag leading-loose rounded-md px-2 py-1 mr-0.5 mb-0.5 border border-gray-600 whitespace-nowrap {{ $gameConcept->typeSlug() }} clickable" {!! $onClick !!}>
    {{ $prepend ?? '' }}
    @if($gameConcept->icon())
        <i class="fa-solid {{ $gameConcept->icon() }} fa-fw"></i>
    @endif
    {{ ($showFullName ?? true) ? $gameConcept->name() : (($showName ?? true) ? $gameConcept->shortName() : '') }}
    {{ $append ?? '' }}

    @if(($showDetails ?? true) && $gameConcept->hasDetails())
        @include('components.details-modal', ['gameConcept' => $gameConcept])
    @endif
</span>
