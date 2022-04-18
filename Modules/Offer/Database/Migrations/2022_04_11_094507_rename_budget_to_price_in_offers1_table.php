<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameBudgetToPriceInOffers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers1', function (Blueprint $table) {
            $table->renameColumn('budget','price');
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
            $table->renameColumn('price','budget');
        });
    }
}
