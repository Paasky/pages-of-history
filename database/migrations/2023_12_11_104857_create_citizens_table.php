<?php

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
            $table->foreignIdFor(\App\Models\Culture::class);
            $table->foreignIdFor(\App\Models\Religion::class)->nullable();
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
