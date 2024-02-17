<?php

use App\Models\Region;
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
            $table->foreignIdFor(Region::class)->constrained();
            $table->unsignedInteger('x');
            $table->unsignedInteger('y');
            $table->string('domain');
            $table->string('surface')->index();
            $table->integer('elevation')->index();
            $table->string('feature')->nullable()->index();
            $table->string('resource')->nullable()->index();
            $table->integer('resource_amount')->nullable();
            $table->string('improvement')->nullable()->index();
            $table->integer('improvement_health')->nullable();
            $table->jsonb('knowledge')->default('[]');
            $table->jsonb('events')->default('[]');
            $table->timestamps();
            $table->index(['x', 'y']);

            $table->unique(['region_id', 'x', 'y']);
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
