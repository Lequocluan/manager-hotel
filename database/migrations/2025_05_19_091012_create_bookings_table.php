<?php

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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->string('notes')->nullable();
            
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'cancelled'])->default('pending');

            $table->boolean('payment_status')->default(0);

            $table->boolean('payment_method')->default(0);

            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
