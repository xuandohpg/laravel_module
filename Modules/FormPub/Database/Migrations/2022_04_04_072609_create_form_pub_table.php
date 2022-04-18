<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormPubTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_pub', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type_data',['input','select','checkbox','radio']);
            $table->string('name_data');
            $table->text('value_data')->nullable();
            $table->string('condition')->nullable();
            $table->json('query')->nullable();
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
        Schema::dropIfExists('form_pub');
    }
}
