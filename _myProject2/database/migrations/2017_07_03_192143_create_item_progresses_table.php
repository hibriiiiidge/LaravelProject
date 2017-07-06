<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemProgressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_progresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('item_id');
            $table->integer('flow_no');
            $table->integer('progress_status');
            $table->text('progress_memo')->nullable();
            $table->string('status');
            $table->integer('rgster');
            $table->integer('updter');
            $table->timestamps();

            $table->foreign('item_id')
                  ->references('id')
                  ->on('items')
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
        Schema::dropIfExists('item_progresses');
    }
}
