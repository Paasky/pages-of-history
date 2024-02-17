<?php

namespace App\Yields;

use App\Enums\YieldType;
use Illuminate\Support\Collection;

class YieldStock
{
    protected Collection $stock;

    public function __construct(array|Collection $stock)
    {
        $this->stock = collect($stock);
    }

    public function put(YieldType $type, float $amount): self
    {
        $this->stock[$type->value] = round(($this->stock[$type->value] ?? 0) + $amount, 2);
        return $this;
    }

    public function takeAll(YieldType $type): float
    {
        $amount = $this->amount($type);
        unset($this->stock[$type->value]);
        return $amount;
    }

    public function amount(YieldType $type): float
    {
        return $this->stock[$type->value] ?? 0;
    }

    public function takeUpTo(YieldType $type, float $amount): self
    {
        return $this->take($type, min($this->amount($type), $amount));
    }

    public function take(YieldType $type, float $amount): self
    {
        if (!$this->has($type, $amount)) {
            throw new \Exception("Stock does not have $amount of $type->value");
        }

        $this->stock[$type->value] = round($this->stock[$type->value] - $amount, 2);
        if ($this->stock[$type->value] <= 0) {
            unset($this->stock[$type->value]);
        }
        return $this;
    }

    public function has(YieldType $type, float $amount): bool
    {
        return $this->amount($type) >= $amount;
    }

    /**
     * @return Collection<string, float>
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }
}
