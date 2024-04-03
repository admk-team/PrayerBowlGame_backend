<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToMinistryPartnersTable extends Migration
{
    public function up()
    {
        Schema::table('ministry_partners', function (Blueprint $table) {
            $table->string('email')->nullable()->after('link');
            $table->string('phone')->nullable()->after('email');
            $table->string('facebook')->nullable()->after('phone');
            $table->string('instagram')->nullable()->after('facebook');
            $table->string('twitter')->nullable()->after('instagram');
            $table->string('youtube')->nullable()->after('twitter');
            $table->string('whatsApp')->nullable()->after('youtube');
            $table->string('tik_tok')->nullable()->after('whatsApp');
            $table->string('linked_in')->nullable()->after('tik_tok');
            $table->string('christian_circle')->nullable()->after('linked_in');
        });
    }

    public function down()
    {
        Schema::table('ministry_partners', function (Blueprint $table) {
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('twitter');
            $table->dropColumn('youtube');
            $table->dropColumn('whatsApp');
            $table->dropColumn('tik_tok');
            $table->dropColumn('linked_in');
            $table->dropColumn('christian_circle');
        });
    }
}
