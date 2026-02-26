<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loading_options', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();           // 'self', 'driver_customer', 'driver_assistant'
            $table->string('label');
            $table->text('description');
            $table->decimal('additional_fee', 8, 2)->default(0.00);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loading_options');
    }
};
