<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorksheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worksheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id', 20)->constrained('members');
            $table->date('work_date');
            $table->dateTime('checkin')->nullable();
            $table->dateTime('checkin_original')->nullable();
            $table->dateTime('checkout')->nullable();
            $table->dateTime('checkout_original')->nullable();
            $table->string('late')->default('10')->nullable();
            $table->string('early')->default('10')->nullable();
            $table->string('in_office')->default('10')->nullable();
            $table->string('ot_time')->default('10')->nullable();
            $table->string('work_time')->default('10')->nullable();
            $table->string('lack')->default('10')->nullable();
            $table->string('compensation')->default('10')->nullable();
            $table->string('paid_leave')->default('10')->nullable();
            $table->string('unpaid_leave')->default('10')->nullable();
            $table->string('note')->default('70')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('worksheets');
    }
}
