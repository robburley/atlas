<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealCalculatorOverviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_calculator_overviews', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('deal_calculator_id');
            $table->string('monthsFree');
            $table->string('lineRental');
            $table->string('bcad');
            $table->string('cashBack');
            $table->string('monthlyDiscount');
            $table->string('monthlyLineRental');
            $table->string('discountMargin');
            $table->string('discountedMonthlyCost');
            $table->string('income');
            $table->string('cost');
            $table->string('handlingFee');
            $table->string('totalProfit');
            $table->string('profitMargin');
            $table->string('status');
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
        Schema::dropIfExists('deal_calculator_overviews');
    }
}
