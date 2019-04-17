<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('allocations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobile_opportunity_id');
            $table->integer('tariff_id');
            $table->string('tariff_name');
            $table->integer('handset_id')->nullable();
            $table->string('handset_name')->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('phone_number')->nullable();
            $table->string('network_from')->nullable();
            $table->string('network_to')->nullable();
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
        Schema::dropIfExists('allocations');
    }
}
