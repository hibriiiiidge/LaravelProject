<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryMakersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_makers', function(Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('maker_id');
            $table->string('status');
            $table->integer('rgster');
            $table->integer('updter');

            $table->index('category_id');
            $table->index('maker_id');

            $table->foreign('category_id')
                  ->references('id')
                  ->on('item_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('maker_id')
                  ->references('id')
                  ->on('item_makers')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_makers');
    }
}
