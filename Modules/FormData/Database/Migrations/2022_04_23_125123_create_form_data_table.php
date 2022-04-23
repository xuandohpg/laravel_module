<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_data', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('traffic');
            $table->string('age');
            $table->string('tags');
            $table->string('country');
            $table->integer('type');
            $table->integer('quantity');
            $table->float('payout');
            $table->float('ar');
            $table->float('cr');
            $table->float('epc');
            $table->integer('classfy');
            $table->integer('exp');
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
        Schema::dropIfExists('form_data');
    }
}
