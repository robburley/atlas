<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_matches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobile_opportunity_id');
            $table->integer('step')->default(1);
            $table->string('current_monthly_cost')->nullable();
            $table->integer('expected_monthly_cost')->nullable();
            $table->string('new_network')->nullable();
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
        Schema::dropIfExists('tariff_matches');
    }
}
