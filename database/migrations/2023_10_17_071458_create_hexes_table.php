<?php

use App\Models\Map;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hexes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Map::class);
            $table->unsignedInteger('x');
            $table->unsignedInteger('y');
            $table->string('surface');
            $table->unsignedInteger('elevation');
            $table->string('feature')->nullable();
            $table->timestamps();
            $table->index(['x', 'y']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hexes');
    }
};
