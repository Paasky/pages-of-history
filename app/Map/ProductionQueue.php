<?php

namespace App\Map;

use App\AbstractType;
use App\GameConcept;
use App\Models\UnitDesign;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

class ProductionQueue implements Arrayable
{
    /**
     * @var Collection|float[][]|AbstractType[][]
     */
    protected array $queue;

    /**
     * @param Collection|array|float[][]|string[][]|AbstractType[][] $queue
     */
    public function __construct(Collection|array $queue)
    {
        $this->queue = [];
        foreach ($queue as $item) {
            $this->queue[] = [
                'progress' => $item['progress'],
                'type' => is_string($item['type'])
                    ? $item['type']::fromSlug($item['slug'])
                    : $item
            ];
        }
    }

    public function add(GameConcept|UnitDesign $item, bool $asFirst = false): self
    {
        if ($asFirst) {
            $this->queue = \Arr::prepend($this->queue, $item);
        } else {
            $this->queue[] = $item;
        }

        return $this;
    }

    public function addProgress(int $production): self
    {
        $this->queue[0]['progress'] += $production;
        return $this;
    }

    public function completeFirstItem(): self
    {
        unset($this->queue[0]);
        $this->queue = array_values($this->queue);
        return $this;
    }

    public function currentProgress(): int|null
    {
        return $this->queue[0]['progress'] ?? null;
    }

    public function producingNow(): GameConcept|UnitDesign|null
    {
        return $this->queue[0]['type'] ?? null;
    }

    /**
     * @return Collection|float[][]|AbstractType[][]
     * @noinspection PhpDocSignatureInspection
     */
    public function getQueue(): Collection
    {
        return $this->queue;
    }

    public function toArray(): array
    {
        $output = [];
        foreach ($this->queue as $item) {
            $output[] = [
                'progress' => $item['progress'],
                'type' => get_class($item['type']),
                'slug' => $item['type']->slug(),
            ];
        }
        return $output;
    }
}
