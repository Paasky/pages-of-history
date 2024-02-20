<?php

namespace App\Map;

use App\AbstractType;
use App\GameConcept;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductionQueue implements Arrayable
{
    /**
     * @var Collection|float[][]|AbstractType[][]
     * @noinspection PhpDocFieldTypeMismatchInspection
     */
    protected Collection $queue;

    /**
     * @param Collection|array|float[][]|string[][]|AbstractType[][] $queue
     */
    public function __construct(Collection|array $queue)
    {
        $this->queue = collect();
        foreach ($queue as $item) {
            $this->queue->push([
                'progress' => $item['progress'],
                'type' => is_string($item['type'])
                    ? $item['type']::fromSlug($item['slug'])
                    : $item
            ]);
        }
    }

    public function add(GameConcept|Model $item, bool $asFirst = false): self
    {
        $asFirst
            ? $this->queue->prepend($item)
            : $this->queue->add($item);

        return $this;
    }

    public function producingNow(): GameConcept|Model|null
    {
        return $this->queue->first();
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
