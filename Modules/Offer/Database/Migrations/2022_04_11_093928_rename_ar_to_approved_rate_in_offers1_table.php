<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameArToApprovedRateInOffers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers1', function (Blueprint $table) {
            $table->renameColumn('ar','approved_rate');
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
            $table->renameColumn('approved_rate','ar');
        });
    }
}
