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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 30);
            $table->string('email', 100);
            $table->string('guests', 50)->default('2 People');
            $table->string('date', 50);
            $table->string('time', 50);
            $table->text('special_requests')->nullable();
            $table->string('status', 30)->default('Pending'); // Pending, Confirmed, Cancelled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
