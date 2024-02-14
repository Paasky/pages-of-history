<?php

use App\Models\City;
use App\Models\Culture;
use App\Models\Religion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('citizens', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(City::class);
            $table->foreignIdFor(Culture::class);
            $table->foreignIdFor(Religion::class)->nullable();
            $table->nullableMorphs('workplace');
            $table->string('desire');
            $table->string('satisfaction');
            $table->integer('riot_turns_left')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
