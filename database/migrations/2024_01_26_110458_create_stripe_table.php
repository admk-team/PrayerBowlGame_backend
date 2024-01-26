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
        Schema::create('stripe', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('card_no');
            $table->string('cvc');
            $table->string('expiration_month');
            $table->string('expiration_year');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe');
    }
};
