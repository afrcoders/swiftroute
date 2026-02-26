<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_id')->constrained('deliveries')->cascadeOnDelete();
            $table->enum('type', ['pickup', 'delivery']);
            $table->string('address');
            $table->string('postal_code', 10);
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('place_id')->nullable();      // Google Place ID
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['delivery_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_stops');
    }
};
