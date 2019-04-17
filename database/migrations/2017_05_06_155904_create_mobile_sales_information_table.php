<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileSalesInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_sales_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mobile_opportunity_id');
            $table->string('business_type');
            $table->string('account_holder');
            $table->timestamp('date_of_birth');
            $table->string('business_name');
            $table->string('landline_number');
            $table->string('mobile_number');
            $table->timestamp('business_established_date')->nullable();
            $table->string('network_porting_from');
            $table->string('current_network_account_number');
            $table->text('special_requirements');
            $table->string('address_1_line_1');
            $table->string('address_1_line_2')->nullable();
            $table->string('address_1_line_3')->nullable();
            $table->string('address_1_line_4')->nullable();
            $table->string('address_1_line_5')->nullable();
            $table->string('address_1_postcode');
            $table->string('address_2_line_1');
            $table->string('address_2_line_2')->nullable();
            $table->string('address_2_line_3')->nullable();
            $table->string('address_2_line_4')->nullable();
            $table->string('address_2_line_5')->nullable();
            $table->string('address_2_postcode');
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
        Schema::dropIfExists('mobile_sales_information');
    }
}
