<?php

namespace App\Enums;
trait PohEnum
{

    public function cssClass(): string
    {
        return \Str::kebab($this->name);
    }

    public function translate(): string
    {
        return \Str::headline($this->name);
    }
}
