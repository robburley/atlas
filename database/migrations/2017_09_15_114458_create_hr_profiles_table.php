<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHrProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_names')->nullable();
            $table->string('last_name')->nullable();
            $table->string('initial')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->timestamp('date_of_birth')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('work_email')->nullable();
            $table->string('passport_number')->nullable();

            $table->string('national_insurance')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('sort_code')->nullable();

            $table->string('employee_id')->nullable();
            $table->timestamp('start_date')->nullable();
            $table->integer('line_manager')->nullable();
            $table->string('job_title')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('probation_period')->nullable();
            $table->string('employee_number')->nullable();
            $table->string('hours_of_work')->nullable();
            $table->string('employee_type')->nullable();

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
        Schema::dropIfExists('hr_profiles');
    }
}
