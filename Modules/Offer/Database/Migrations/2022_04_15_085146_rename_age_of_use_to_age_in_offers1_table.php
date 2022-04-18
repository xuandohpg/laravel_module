<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameAgeOfUseToAgeInOffers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers1', function (Blueprint $table) {
            $table->renameColumn('age_of_use','age');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offers1', function (Blueprint $table) {
            $table->renameColumn('age','age_of_use');
        });
    }
}
