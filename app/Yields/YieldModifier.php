<?php

namespace App\Yields;

use App\AbstractType;
use App\Enums\YieldType;
use App\GameConcept;
use App\Models\Building;
use App\Models\Citizen;
use App\Models\City;
use App\Models\Hex;
use App\Models\Unit;
use App\Models\UnitDesign;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class YieldModifier
{
    public function __construct(
        public GameConcept|Model $givenBy,
        public YieldType $type,
        public float     $amount = 0,
        public float     $percent = 0
    )
    {
    }

    /**
     * Combine YieldTypes (amounts and percents) into single amounts, forgetting what gave them originally
     * @param Collection<int, YieldModifier|YieldModifiersFor|YieldModifiersTowards> $modifiers
     * @return Collection<int, YieldModifier|YieldModifiersFor|YieldModifiersTowards>
     */
    public static function combineYieldTypes(Collection $modifiers, GameConcept|Model $givenBy): Collection
    {
        // Separate the two types of modifiers
        $regularModifiers = [];
        $forModifiers = [];
        /** @var YieldModifier|YieldModifiersFor|YieldModifiersTowards $modifier */
        foreach ($modifiers as $modifier) {
            // Regular YieldModifiers are a simple list
            if ($modifier instanceof YieldModifier) {
                $regularModifiers[] = $modifier;
                continue;
            }
            $forModifiers[] = $modifier;
        }

        /** @var YieldModifier[] $modifierByYieldType */
        $modifierByYieldType = [];
        foreach ($regularModifiers as $modifier) {
            $yieldType = $modifier->type->value;
            if (!isset($modifierByYieldType[$yieldType])) {
                $modifierByYieldType[$yieldType] = [
                    '+' => max($modifier->amount, 0),
                    '-' => min($modifier->amount, 0),
                    '%' => $modifier->percent,
                ];
                continue;
            }

            $modifierByYieldType[$yieldType]['+'] += max($modifier->amount, 0);
            $modifierByYieldType[$yieldType]['-'] += min($modifier->amount, 0);
            $modifierByYieldType[$yieldType]['%'] += $modifier->percent;
        }

        foreach ($modifierByYieldType as $yieldType => $modifier) {
            $positive = $modifier['+'];
            $negative = $modifier['-'];
            $percent = $modifier['%'];

            if ($percent && $positive) {
                $positive += $positive * $percent / 100;
            }
            if ($percent && !$positive) {
                $negative += abs($negative) * $percent / 100;
            }
            $amount = round($positive + $negative, 2);

            if ($amount) {
                $modifierByYieldType[$yieldType] = new YieldModifier($givenBy, YieldType::from($yieldType), $amount);
            } else {
                unset($modifierByYieldType[$yieldType]);
            }
        }

        return collect($modifierByYieldType)->sortKeys()->values()->merge($forModifiers);
    }

    /**
     * Given a list of YieldModifier & YieldModifiersFor objects,
     * returns YieldModifiers that apply for the given GameConcept or Model
     *
     * @param Collection<int, YieldModifier|YieldModifiersFor|YieldModifiersTowards> $modifiers Modifiers to validate
     * @param GameConcept|Model|Collection<GameConcept|Model> $for Must be valid for this object. [null] = none pass, [] = all pass
     * @param GameConcept|Model|Collection<GameConcept|Model>|null $against Must be valid against this object. [null] = none pass, [] = all pass
     * @param bool $combine Should Modifiers be combined, forgetting what gave them originally
     * @return Collection<int, YieldModifier|YieldModifiersFor|YieldModifiersTowards>
     * @throws \Exception
     */
    public static function getValidModifiers(
        Collection                   $modifiers,
        GameConcept|Model|Collection $for,
        GameConcept|Model|Collection $against = null,
        bool                         $combine = false
    ): Collection
    {
        // Expand $for & $against
        $forObjects = static::withParents($for);
        $againstObjects = static::withParents($against);

        $validModifiers = collect();
        $appendModifiers = collect();

        foreach ($modifiers as $modifier) {
            // Regular YieldModifiers
            if ($modifier instanceof YieldModifier) {
                // Include if the YieldType is for one of the given $fors
                if ($modifier->type->isFor(...$forObjects)) {
                    $validModifiers->push($modifier);
                }
                continue;
            }

            // YieldModifiersFor/Against are more complex

            // If no objects were given to check against, the modifier is always valid
            $checkForObjects = $modifier instanceof YieldModifiersTowards
                ? $againstObjects
                : $forObjects;
            $modifierIsValid = $checkForObjects->isEmpty();

            if (!$modifierIsValid) {
                foreach ($modifier->for as $modifierFor) {
                    if ($modifierFor->is(...$checkForObjects)) {
                        $modifierIsValid = true;
                        break;
                    }
                }
            }

            if ($modifierIsValid) {
                // Combine into simple modifiers only if a check was made
                if ($combine && $checkForObjects->isNotEmpty()) {
                    $validModifiers = $validModifiers->merge(
                        static::getValidModifiers($modifier->modifiers, $for, $against)
                    );
                } else {
                    $appendModifiers->push($modifier);
                }
            }
        }

        return $combine
            ? static::combineYieldTypes($validModifiers->merge($appendModifiers), $for)
            : $validModifiers
                ->sort(fn(YieldModifier $a, YieldModifier $b) => $a->type->value > $b->type->value)
                ->merge($appendModifiers);
    }

    /**
     * @param Collection<GameConcept|Model>|GameConcept|Model|null $objects
     * @return Collection
     */
    public static function withParents(Collection|GameConcept|Model|null $objects): Collection
    {
        if (!$objects) {
            return collect();
        }

        if (!$objects instanceof Collection) {
            $objects = [$objects];
        }

        $objectAndParents = [];
        foreach ($objects as $object) {
            $objectAndParents[] = $object;

            if ($object === null) {
                continue;
            }

            if ($object instanceof AbstractType) {
                $objectAndParents[] = $object->category();
                continue;
            }

            if ($object instanceof GameConcept) {
                foreach ($object->items() as $item) {
                    $objectAndParents[] = $item;
                }
                if (method_exists($object, 'class')) {
                    $objectAndParents[] = $object->class();
                }
                continue;
            }

            if ($object instanceof Building) {
                foreach (static::withParents(collect([$object->type])) as $typeFor) {
                    $objectAndParents[] = $typeFor;
                }
                continue;
            }

            if ($object instanceof City) {
                // Cities don't have any parents
                continue;
            }

            if ($object instanceof Citizen) {
                foreach (static::withParents(collect([$object->workplace])) as $typeFor) {
                    $objectAndParents[] = $typeFor;
                }
                continue;
            }

            if ($object instanceof Hex) {
                $objectsToCrawl = collect([
                    $object->domain,
                    $object->surface,
                    $object->feature,
                    $object->resource,
                    $object->improvement,
                ])->filter()
                    ->merge($object->buildings);

                foreach (static::withParents($objectsToCrawl) as $crawledObject) {
                    $objectAndParents[] = $crawledObject;
                }
                continue;
            }

            if ($object instanceof Unit) {
                $objectsToCrawl = collect([
                    $object->unitDesign->platform,
                    $object->unitDesign->equipment,
                    $object->unitDesign->armor,
                ])->filter();

                foreach (static::withParents($objectsToCrawl) as $crawledObject) {
                    $objectAndParents[] = $crawledObject;
                }
                continue;
            }

            if ($object instanceof UnitDesign) {
                $objectsToCrawl = collect([
                    $object->platform,
                    $object->equipment,
                    $object->armor,
                ])->filter();

                foreach (static::withParents($objectsToCrawl) as $crawledObject) {
                    $objectAndParents[] = $crawledObject;
                }
                continue;
            }

            throw new \Exception(
                'Invalid object to get parents for: ' . (is_object($object) ? get_class($object) : gettype($object))
            );
        }
        return collect($objectAndParents);
    }

    public function color(): string
    {
        return ($this->amount ?: $this->percent) < 0 ? 'red' : 'green';
    }

    public function effect(): string
    {
        return implode([
            $this->percent && $this->percent > 0 ? '+' : '',
            $this->amount ?: $this->percent,
            $this->percent ? '%' : '',
        ]);
    }
}
