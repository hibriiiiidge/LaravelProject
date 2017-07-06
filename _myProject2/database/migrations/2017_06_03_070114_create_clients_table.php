<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('attributes');
            $table->integer('base');
            $table->string('name');
            $table->string('kana');
            $table->integer('gender');
            $table->integer('job');
            $table->string('birthday');
            $table->string('tel');
            $table->string('mail');
            $table->string('postal_code');
            $table->integer('prefecture');
            $table->string('address');
            $table->string('memo');
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
        Schema::dropIfExists('clients');
    }
}
