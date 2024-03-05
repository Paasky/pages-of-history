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

    public function amount(YieldType $type): float
    {
        return $this->stock[$type->value] ?? 0;
    }

    /**
     * @return Collection<string, float>
     */
    public function getStock(): Collection
    {
        return $this->stock;
    }

    public function has(YieldType $type, float $amount): bool
    {
        return $this->amount($type) >= $amount;
    }

    public function put(YieldType $type, float $amount): self
    {
        if ($amount < 0) {
            return $this->take($type, abs($amount));
        }

        $this->stock[$type->value] = round(($this->stock[$type->value] ?? 0) + $amount, 2);
        return $this;
    }

    public function take(YieldType $type, float $amount): self
    {
        if ($amount < 0) {
            return $this->put($type, abs($amount));
        }

        if (!$this->has($type, $amount)) {
            throw new \Exception("Stock does not have $amount of $type->value");
        }

        $this->stock[$type->value] = round($this->stock[$type->value] - $amount, 2);
        if ($this->stock[$type->value] <= 0) {
            unset($this->stock[$type->value]);
        }
        return $this;
    }

    public function takeAll(YieldType $type): float
    {
        $amount = $this->amount($type);
        unset($this->stock[$type->value]);
        return $amount;
    }

    public function takeUpTo(YieldType $type, float $amount): self
    {
        if ($amount < 0) {
            return $this->put($type, abs($amount));
        }

        return $this->take($type, min($this->amount($type), $amount));
    }
}
