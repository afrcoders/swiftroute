<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference', 20)->unique();

            // Customer info
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone', 20);
            $table->string('email');

            // Vehicle
            $table->foreignId('vehicle_type_id')->constrained('vehicle_types');

            // Schedule
            $table->date('pickup_date');
            $table->foreignId('time_slot_id')->constrained('time_slots');

            // Loading option
            $table->foreignId('loading_option_id')->constrained('loading_options');

            // Pricing
            $table->decimal('distance_km', 8, 2);
            $table->decimal('base_price', 10, 2);
            $table->decimal('loading_fee', 10, 2)->default(0.00);
            $table->decimal('vehicle_surcharge', 10, 2)->default(0.00);
            $table->decimal('surge_fee', 10, 2)->default(0.00);
            $table->decimal('total_price', 10, 2);

            // Status
            $table->enum('status', ['pending', 'confirmed', 'in_progress', 'completed', 'cancelled'])
                  ->default('pending');

            // Notes
            $table->text('admin_notes')->nullable();
            $table->text('customer_notes')->nullable();

            // Items
            $table->json('items')->nullable();           // [{name, quantity}]
            $table->json('uploaded_images')->nullable();  // file paths

            $table->timestamps();
            $table->softDeletes();

            $table->index('booking_reference');
            $table->index('status');
            $table->index('pickup_date');
            $table->index('email');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
