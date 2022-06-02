<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_code', 10)->nullable();
            $table->string('full_name', 20);
            $table->string('email', 80)->unique();
            $table->string('nick_name', 80)->nullable();
            $table->string('password', 80);
            $table->string('remember_token', 80)->nullable();
            $table->string('other_email', 50)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('skype', 30)->nullable();
            $table->string('facebook', 100)->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('marital_status')->default(1);
            $table->string('avatar')->nullable();
            $table->string('avatar_official')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('temporary_address')->nullable();
            $table->string('identity_number', 12)->nullable();
            $table->date('identity_card_date')->nullable();
            $table->string('identity_card_place', 50)->nullable();
            $table->string('passport_number', 20)->nullable();
            $table->date('passport_expiration')->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('emergency_contact_name', 70)->nullable();
            $table->string('emergency_contact_relationship', 50)->nullable();
            $table->string('emergency_contact_number', 20)->nullable();
            $table->string('academic_level', 50)->nullable();
            $table->string('graduate_year', 4)->nullable();
            $table->string('bank_name', 30)->nullable();
            $table->string('bank_account', 20)->nullable();
            $table->string('tax_identification', 20)->nullable();
            $table->date('tax_date', 80)->nullable();
            $table->string('tax_place', 50)->nullable();
            $table->string('insurance_number', 20)->nullable();
            $table->string('healthcare_provider', 30)->nullable();
            $table->date('start_date_official')->nullable();
            $table->date('start_date_probation')->nullable();
            $table->date('end_date', 80)->nullable();
            $table->tinyInteger('status')->nullable();
            $table->text('note', 80)->nullable();
            $table->timestamps();
            $table->bigInteger('created_by');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
