<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_details', function (Blueprint $table) {
              $table->increments('id');
              $table->string('request_id');
              $table->string('client_id');
              $table->string('urgency')->nullable();
              $table->integer('buy_way')->nullable();
              $table->integer('way')->nullable();
              $table->integer('route')->nullable();
              $table->integer('competitive_flg')->nullable();
              $table->text('summary_memo')->nullable();
              $table->string('status');
              $table->integer('rgster');
              $table->integer('updter');
              $table->timestamps();

              $table->foreign('client_id')
                    ->references('id')
                    ->on('clients')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_details');
    }
}
