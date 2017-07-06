<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumsAboutPriceToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->integer('estimate_price')->nullable();
            $table->integer('expsell_min_price')->nullable();
            $table->integer('expsell_max_price')->nullable();
            $table->integer('exp_min_profit')->nullable();
            $table->integer('exp_max_profit')->nullable();
            $table->integer('exp_min_profit_rate')->nullable();
            $table->integer('exp_max_profit_rate')->nullable();
            $table->integer('buy_price')->nullable();
            $table->integer('sell_price')->nullable();
            $table->integer('profit')->nullable();
            $table->integer('profit_rate')->nullable();
            $table->integer('number')->nullable();
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
            $table->dropColumn('estimate_price');
            $table->dropColumn('expsell_min_price');
            $table->dropColumn('expsell_max_price');
            $table->dropColumn('exp_min_profit');
            $table->dropColumn('exp_max_profit');
            $table->dropColumn('exp_min_profit_rate');
            $table->dropColumn('exp_max_profit_rate');
            $table->dropColumn('buy_price');
            $table->dropColumn('sell_price');
            $table->dropColumn('profit');
            $table->dropColumn('profit_rate');
            $table->dropColumn('number');
        });
    }
}
