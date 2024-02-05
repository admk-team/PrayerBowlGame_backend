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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('banner')->nullable();
            $table->text('content');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('views')->default(0);
            $table->integer('clicks')->default(0);
            $table->integer('max_views')->nullable();
            $table->integer('max_clicks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
