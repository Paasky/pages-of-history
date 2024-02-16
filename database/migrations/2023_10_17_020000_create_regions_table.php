<?php

use App\Models\Map;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Map::class)->constrained();
            $table->unsignedInteger('x');
            $table->unsignedInteger('y');
            $table->string('domain');
            $table->string('surface');
            $table->integer('elevation');
            $table->string('feature')->nullable();
            $table->index(['x', 'y']);

            $table->unique(['map_id', 'x', 'y']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regions');
    }
};
