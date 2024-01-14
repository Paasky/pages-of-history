<?php

namespace App\Enums;
trait PohEnum
{
    /**
     * @param ...$enums
     * @return bool
     */
    public function is(...$enums): bool
    {
        foreach ($enums as $enum) {
            if ($this->value === $enum->value) {
                return true;
            }
        }
        return false;
    }

    public function cssClass(): string
    {
        return \Str::kebab($this->name);
    }

    public function translate(): string
    {
        return \Str::headline($this->name);
    }
}
