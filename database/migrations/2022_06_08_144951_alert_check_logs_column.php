<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlertCheckLogsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('check_logs', function (Blueprint $table) {
            $table->dateTime('checktime')->nullable()->change();
            $table->dateTime('created_at')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('check_logs', function (Blueprint $table) {
            $table->dropColumn('checktime');
            $table->dropColumn('created_at');
        });
    }
}
