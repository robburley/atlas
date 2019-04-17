<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColourToDealRelatedTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tariff_match_requirements', function (Blueprint $table) {
            $table->string('colour')->nullable();
        });

        Schema::table('deal_calculator_handsets', function (Blueprint $table) {
            $table->string('colour')->nullable();
            $table->integer('handset_id')->nullable();
            $table->string('name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
