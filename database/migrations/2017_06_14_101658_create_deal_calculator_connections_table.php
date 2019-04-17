<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealCalculatorConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_calculator_connections', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('primary');
            $table->integer('deal_calculator_id');
            $table->string('tariff_id')->nullable();
            $table->string('tariff_name')->nullable();
            $table->string('term');
            $table->string('connections');
            $table->string('cost');
            $table->string('gp');
            $table->string('commission');
            $table->string('total');
            $table->string('modifier');
            $table->string('type');
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
        Schema::dropIfExists('deal_calculator_connections');
    }
}
