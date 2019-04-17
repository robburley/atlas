<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyMeterEnergyOpportunityTable extends Migration
{
    public $table = 'energy_meter_energy_opportunity';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('energy_meter_id')->unsigned();
            $table->foreign('energy_meter_id')->references('id')->on('users');
            $table->integer('energy_opportunity_id')->unsigned();
            $table->foreign('energy_opportunity_id')->references('id')->on('energy_opportunities');
            $table->boolean('active')->default(1);
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
        //
    }
}
