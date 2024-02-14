<?php

use App\Models\Player;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unit_designs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Player::class)->constrained();
            $table->string('name');
            $table->string('platform')->index();
            $table->string('equipment')->index();
            $table->string('armor')->nullable()->index();
            $table->string('type')->index();
            $table->timestamps();


            $table->unique(['player_id', 'platform', 'equipment', 'armor']);
            $table->unique(['player_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_designs');
    }
};
