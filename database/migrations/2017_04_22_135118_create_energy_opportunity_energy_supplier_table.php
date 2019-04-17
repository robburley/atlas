<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyOpportunityEnergySupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_opportunity_energy_supplier', function (Blueprint $table) {
            $table->integer('energy_supplier_id')->unsigned()->index();
            $table->foreign('energy_supplier_id')->references('id')->on('energy_suppliers')->onDelete('cascade');
            $table->integer('energy_opportunity_id')->unsigned()->index();
            $table->foreign('energy_opportunity_id')->references('id')->on('energy_opportunities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('energy_opportunity_energy_supplier');
    }
}
