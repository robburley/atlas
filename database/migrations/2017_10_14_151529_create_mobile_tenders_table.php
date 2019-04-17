<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileTendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_tenders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tender_id');
            $table->string('allocation_id');
            $table->integer('selected_supplier_id')->nullable();
            $table->integer('selected_unit_price')->nullable();
            $table->integer('selected_lead_time')->nullable();

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
        Schema::dropIfExists('mobile_tenders');
    }
}
