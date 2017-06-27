<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsAboutBankToRequestDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_details', function (Blueprint $table) {
           $table->string('bank_name')->nullable();
           $table->string('bank_code')->nullable();
           $table->string('branch_name')->nullable();
           $table->string('branch_code')->nullable();
           $table->integer('account_kind')->nullable();
           $table->string('account_number')->nullable();
           $table->string('account_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_details', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('bank_code');
            $table->dropColumn('branch_name');
            $table->dropColumn('branch_code');
            $table->dropColumn('account_kind');
            $table->dropColumn('account_number');
            $table->dropColumn('account_name');
        });
    }
}
