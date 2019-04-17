\<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedLineCustomerInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_line_customer_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fixed_line_opportunity_id');
            $table->string('company');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('address_3')->nullable();
            $table->string('address_4')->nullable();
            $table->string('postcode');
            $table->string('customer_name');
            $table->string('position');
            $table->string('email');
            $table->string('billing_email');
            $table->string('office_number');
            $table->string('mobile_number')->nullable();
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
        Schema::dropIfExists('fixed_line_customer_information');
    }
}
