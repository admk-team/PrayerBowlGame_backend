<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateLanguageFieldInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Update existing NULL values to 'en'
        DB::table('users')->whereNull('language')->update(['language' => 'en']);

        Schema::table('users', function (Blueprint $table) {
            // Set the default value of 'en' for the language field and remove nullable
            $table->string('language')->default('en')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert to the previous state (nullable and no default value)
            $table->string('language')->nullable()->default(null)->change();
        });
    }
}