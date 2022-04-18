<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSocialNetworkToTrafficNetworkInOffers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offers1', function (Blueprint $table) {
            $table->renameColumn('social_network','traffic_network');
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
            $table->renameColumn('traffic_network','social_network');
        });
    }
}
