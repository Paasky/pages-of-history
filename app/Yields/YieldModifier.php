<?php

namespace App\Yields;

use App\Enums\YieldType;

class YieldModifier
{
    public string $effect;
    public string $color;

    public function __construct(
        public YieldType $type,
        public float     $amount = 0,
        public float     $percent = 0
    )
    {
        $this->color = ($amount ?: $percent) < 0 ? 'red' : 'green';
        $this->effect = implode([
            ($amount ?: $percent) < 0 ? '' : '+',
            $amount ?: $percent,
            $this->percent ? '%' : '',
        ]);
    }
}
