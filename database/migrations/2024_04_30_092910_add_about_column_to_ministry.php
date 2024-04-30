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
        Schema::table('ministry_partners', function (Blueprint $table) {
            $table->string('about')->nullable()->after('christian_circle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ministry_partners', function (Blueprint $table) {
            $table->dropColumn('about');
        });
    }
};
