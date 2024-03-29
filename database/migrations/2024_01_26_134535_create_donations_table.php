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
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('card_number');
            $table->string('name_on_card');
            $table->string('expiry_date');
            $table->string('cvv');
            $table->string('supporter_name')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->decimal('donation_amount', 8, 2);
            $table->string('donation_type');
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
