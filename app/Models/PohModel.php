<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait PohModel
{
    public function getNameAttribute(): string
    {
        return class_basename($this) . " $this->id";
    }

    public static function table(): string
    {
        return (new static())->getTable();
    }

    public static function keyName(): string
    {
        return (new static())->getKeyName();
    }
}
