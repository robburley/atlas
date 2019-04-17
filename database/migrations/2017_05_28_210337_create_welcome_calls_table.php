<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWelcomeCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('welcome_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('opportunity_type')->default('mobileOpportunity');
            $table->integer('opportunity_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('telephone')->nullable();
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('welcome_calls');
    }
}
