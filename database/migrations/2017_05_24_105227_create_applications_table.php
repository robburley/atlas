<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id')->nullable();
            $table->integer("position_id")->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string("commitments")->nullable();
            $table->string("children")->nullable();
            $table->string("married")->nullable();
            $table->text("experience")->nullable();
            $table->text("current_role")->nullable();
            $table->text("change_reason")->nullable();
            $table->text("best_job")->nullable();
            $table->text("biggest_achievement")->nullable();
            $table->text("drive")->nullable();
            $table->text("bring_to_business")->nullable();
            $table->text("suitable_reason")->nullable();
            $table->text("best_attributes")->nullable();
            $table->text("development_areas")->nullable();
            $table->integer('confidence')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
