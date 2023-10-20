<?php

namespace Tests\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Paasky\LaravelModelTest\TestsModels;
use Tests\TestCase;

class RelationsTest extends TestCase
{
    use RefreshDatabase;
    use TestsModels;

    /**
     * A basic test example.
     */
    public function testRelations(): void
    {
        $this->assertModels();
    }
}
