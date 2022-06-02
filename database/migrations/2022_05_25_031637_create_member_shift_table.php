<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_shift', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('shift_id')->constrained('shifts');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('free_check')->default('0')->nullable();
            $table->bigInteger('part_time')->default('0')->nullable();
            $table->string('note', 255)->nullable();
            $table->bigInteger('created_by');
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
        Schema::dropIfExists('member_shift');
    }
}
