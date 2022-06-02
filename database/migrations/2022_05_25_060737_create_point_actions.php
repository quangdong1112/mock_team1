<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointActions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('point_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id', 20)->constrained('members');
            $table->date('date');
            $table->char('month', 7);
            $table->char('year', 4);
            $table->string('action', 100);
            $table->integer('point');
            $table->tinyInteger('status')->default('0');
            $table->bigInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_actions');
    }
}
