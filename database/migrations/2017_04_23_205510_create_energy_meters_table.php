<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_meters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->integer('customer_id');
            $table->string('type');
            $table->string('quantity');
            $table->string('day_rate');
            $table->string('night_rate');
            $table->string('current_standing_charge');
            $table->timestamp('contract_end_date');
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
        Schema::dropIfExists('energy_meters');
    }
}
