<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedLineNetworkFixedLineOpportunityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_line_network_fixed_line_opportunity', function (Blueprint $table) {
            $table->integer('fixed_line_network_id')->unsigned();
            $table->integer('fixed_line_opportunity_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fixed_line_network_fixed_line_opportunity');
    }
}
