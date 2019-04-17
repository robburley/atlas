<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashFlowItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_flow_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobile_opportunity_id');
            $table->timestamp('sales_date');
            $table->integer('branch_id');
            $table->string('company_name');
            $table->integer('sales_person_id');
            $table->integer('lead_generator_id');
            $table->integer('turnover');
            $table->integer('hardware_fund');
            $table->integer('hardware_fund_vat');
            $table->integer('handling_fees');
            $table->integer('handsets');
            $table->integer('sims');
            $table->integer('sim_saves');
            $table->integer('delivery');
            $table->integer('total_cashback');
            $table->integer('total_cashback_vat');
            $table->integer('board_gp');
            $table->integer('additional_percent');
            $table->integer('additional_pounds');
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
        Schema::dropIfExists('cash_flow_items');
    }
}
