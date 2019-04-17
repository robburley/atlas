<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffMatchRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariff_match_requirements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tariff_match_id');

            $table->string('type');
            $table->string('network');
            $table->string('name');
            $table->integer('device');
            $table->integer('mins');
            $table->integer('data');

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
        Schema::dropIfExists('tariff_match_requirements');
    }
}
