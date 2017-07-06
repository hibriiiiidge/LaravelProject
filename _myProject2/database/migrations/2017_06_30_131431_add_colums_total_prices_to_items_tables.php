<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsTotalPricesToItemsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('total_estimate_price')->nullable();
            $table->integer('total_expsell_min_price')->nullable();
            $table->integer('total_expsell_max_price')->nullable();
            $table->integer('total_exp_min_profit_price')->nullable();
            $table->integer('total_exp_max_profit_price')->nullable();
            $table->integer('total_buy_price')->nullable();
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
            $table->dropColum('total_estimate_price');
            $table->dropColum('total_expsell_min_price');
            $table->dropColum('total_expsell_max_price');
            $table->dropColum('total_exp_min_profit_price');
            $table->dropColum('total_exp_max_profit_price');
            $table->dropColum('total_buy_price');
        });
    }
}
