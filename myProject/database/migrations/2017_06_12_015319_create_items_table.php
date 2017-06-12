<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->string('request_id');
            $table->integer('category')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('items');
    }
}
