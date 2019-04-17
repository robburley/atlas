<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_line_commercial_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fixed_line_commercial_id');

            $table->integer('type');
            $table->string('telephone_number')->nullable();
            $table->integer('monthly_line_rental');
            $table->string('installation_postcode');
            $table->boolean('has1571');
            $table->boolean('call_divert');
            $table->boolean('call_waiting');
            $table->boolean('caller_display');
            $table->integer('broadband');

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
        Schema::dropIfExists('fixed_line_commercial_lines');
    }
}
