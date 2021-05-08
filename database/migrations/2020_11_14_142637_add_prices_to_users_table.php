<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPricesToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('n'); //poids normal 
            $table->integer('v'); //poids voluminaux
            $table->integer('nh'); // p normal hors zone
            $table->integer('vh'); // p voluminaix hors zone
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
            $table->dropColumn('n');
            $table->dropColumn('v');
            $table->dropColumn('nh');
            $table->dropColumn('vh');

        });
    }
}
