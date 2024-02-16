<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCultureRequest;
use App\Http\Requests\UpdateCultureRequest;
use App\Models\Culture;

class CultureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCultureRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Culture $culture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Culture $culture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCultureRequest $request, Culture $culture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Culture $culture)
    {
        //
    }
}
