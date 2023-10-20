<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Model
 */
trait PohModel
{
    public static function table(): string
    {
        return (new static())->getTable();
    }

    public static function keyName(): string
    {
        return (new static())->getKeyName();
    }
}
