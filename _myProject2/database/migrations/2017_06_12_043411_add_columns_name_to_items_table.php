<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsNameToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('name')->nullable();
            $table->integer('outside_condition')->nullable();
            $table->integer('inside_condition')->nullable();
            $table->integer('cooling_off_flg')->nullable();
            $table->text('memo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('outside_condition');
            $table->dropColumn('inside_condition');
            $table->dropColumn('cooling_off_flg');
            $table->dropColumn('memo');
        });
    }
}
