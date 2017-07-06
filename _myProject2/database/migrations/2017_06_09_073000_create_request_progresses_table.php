<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('request_progresses', function (Blueprint $table) {
          $table->increments('id');
          $table->string('request_id');
          $table->integer('flow_no');
          $table->integer('progress_status');
          $table->text('progress_memo')->nullable();
          $table->string('status');
          $table->integer('rgster');
          $table->integer('updter');
          $table->timestamps();

          $table->foreign('request_id')
                ->references('request_id')
                ->on('request_details')
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
        Schema::dropIfExists('request_progresses');
    }
}
