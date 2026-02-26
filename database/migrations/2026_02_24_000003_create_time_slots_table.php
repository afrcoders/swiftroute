<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('label');                    // e.g. '8:00 AM - 8:30 AM'
            $table->tinyInteger('day_of_week')->nullable(); // 0=Sun..6=Sat, null=all days
            $table->integer('max_bookings')->default(1);    // max concurrent bookings per slot
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->index(['is_active', 'day_of_week']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
