<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameCompanyNumberToMobileSalesInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_sales_information', function (Blueprint $table) {
            $table->string('account_holder_title')->nullable();
            $table->string('account_holder_last_name')->nullable();
            $table->string('company_number')->nullable();
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
