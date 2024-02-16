<?php

use App\Models\Map;
use App\Models\Religion;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->nullable()->constrained();
            $table->foreignIdFor(Map::class)->constrained();
            $table->foreignIdFor(Religion::class)->nullable();
            $table->string('color1');
            $table->string('color2');
            $table->jsonb('yield_stock')->nullable();
            $table->timestamps();

            $table->unique(['map_id', 'user_id']);
            $table->unique(['map_id', 'color1', 'color2']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
