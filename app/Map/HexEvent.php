<?php

namespace App\Map;

use Illuminate\Contracts\Support\Arrayable;

class HexEvent implements Arrayable
{
    public function __construct(
        protected int    $turn,
        protected string $description
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            $data['turn'],
            $data['description']
        );
    }

    public function toArray(): array
    {
        return [
            'turn' => $this->turn,
            'description' => $this->description,
        ];
    }
}
