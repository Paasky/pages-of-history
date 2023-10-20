<?php

namespace App\Http\Controllers;

use App\Managers\UnitManager;
use App\Models\Hex;
use App\Models\Unit;

class UnitController extends Controller
{
    public function move(Unit $unit, Hex $to)
    {
        $this->authorize('update', $unit);
        UnitManager::for($unit)->move($to);
        return response()->json($unit);
    }
}
