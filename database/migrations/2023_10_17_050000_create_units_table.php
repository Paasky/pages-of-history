<?php

use App\Models\City;
use App\Models\Hex;
use App\Models\Player;
use App\Models\UnitDesign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Hex::class)->constrained();
            $table->foreignIdFor(Player::class)->constrained();
            $table->foreignIdFor(UnitDesign::class)->constrained();
            $table->foreignIdFor(City::class)->nullable()->constrained();
            $table->string('type')->index();
            $table->integer('health')->default(100);
            $table->float('moves_remaining', 3, 1)->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['hex_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
