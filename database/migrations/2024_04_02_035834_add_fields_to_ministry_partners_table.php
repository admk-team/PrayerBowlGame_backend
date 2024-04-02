<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMinistryPartnersTable extends Migration
{
    public function up()
    {
        Schema::table('ministry_partners', function (Blueprint $table) {
            $table->string('media_links')->nullable();
            $table->string('media_icon')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
        });
    }

    public function down()
    {
        Schema::table('ministry_partners', function (Blueprint $table) {
            $table->dropColumn('media_links');
            $table->dropColumn('media_icon');
            $table->dropColumn('email');
            $table->dropColumn('phone');
        });
    }
}
