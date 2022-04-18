<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffers1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers1', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('tags');
            $table->string('country');
            $table->float('ar');
            $table->integer('age_of_use');
            $table->float('budget');
            $table->float('conversion_rate');
            $table->string('social_network');
            $table->string('link_landing');
            $table->string('exp');
            $table->float('payout');
            $table->integer('priority');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers1');
    }
}
