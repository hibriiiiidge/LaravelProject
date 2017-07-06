<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('base_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('postal_code');
            $table->integer('prefecture');
            $table->string('address');
            $table->string('tel');
            $table->string('fax');
            $table->string('mail');
            $table->string('status');
            $table->integer('rgster');
            $table->integer('updter');
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
        Schema::dropIfExists('base_types');
    }
}
