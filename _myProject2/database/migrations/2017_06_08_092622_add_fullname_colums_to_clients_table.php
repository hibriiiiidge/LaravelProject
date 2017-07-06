<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFullnameColumsToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            //追加カラム
            $table->string('fullname');
            $table->string('first_name');
            $table->string('first_name_kana');
            $table->string('fax');
            //null許容に変更
            $table->integer('gender')->nullable()->change();
            $table->integer('job')->nullable()->change();
            $table->string('birthday')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('fullname');
            $table->dropColumn('first_name');
            $table->dropColumn('first_name_kana');
            $table->dropColumn('fax');
        });
    }
}
