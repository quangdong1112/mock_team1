<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id', 20)->constrained('members');
            $table->tinyInteger('request_type')->default('1');
            $table->date('request_for_date');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
            $table->string('compensation_time', 10)->nullable();
            $table->date('compensation_date')->nullable();
            $table->tinyInteger('leave_all_day')->nullable();
            $table->string('leave_start', 10)->nullable();
            $table->string('leave_end', 10)->nullable();
            $table->string('leave_time', 10)->nullable();
            $table->string('request_ot_time', 10)->nullable();
            $table->string('reason', 100)->nullable();
            $table->tinyInteger('status')->default('0');
            $table->tinyInteger('manager_confirmed_status')->default('0');
            $table->dateTime('manager_confirmed_at')->nullable();
            $table->string('manager_confirmed_comment', 100)->nullable();
            $table->tinyInteger('admin_approved_status')->default('0');
            $table->dateTime('admin_approved_at')->nullable();
            $table->string('admin_approved_comment', 100)->nullable();
            $table->tinyInteger('error_count')->default('0');
            $table->timestamps();
            $table->softDeletes()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requests');
    }
}
