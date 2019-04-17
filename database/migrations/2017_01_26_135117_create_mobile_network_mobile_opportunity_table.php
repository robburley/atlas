<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileNetworkMobileOpportunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_network_mobile_opportunity', function (Blueprint $table) {
            $table->integer('mobile_network_id')->unsigned()->index();
            $table->foreign('mobile_network_id')->references('id')->on('mobile_networks')->onDelete('cascade');
            $table->integer('mobile_opportunity_id')->unsigned()->index();
            $table->foreign('mobile_opportunity_id')->references('id')->on('mobile_opportunities')->onDelete('cascade');
            $table->boolean('open_to')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mobile_network_mobile_opportunity');
    }
}
