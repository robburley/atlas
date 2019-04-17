<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDeliveryAddressToMobileSalesInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_sales_information', function (Blueprint $table) {
            $table->string('address_3_line_1');
            $table->string('address_3_line_2')->nullable();
            $table->string('address_3_line_3')->nullable();
            $table->string('address_3_line_4')->nullable();
            $table->string('address_3_line_5')->nullable();
            $table->string('address_3_postcode');
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
