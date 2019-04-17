<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('title');
            $table->string('forename');
            $table->string('surname')->index();
            $table->string('job_title')->nullable();
            $table->string('description')->nullable();
            $table->string('landline_number')->index()->nullable();
            $table->string('mobile_number')->index()->nullable();
            $table->string('email_address')->index()->nullable();
            $table->string('address_line1')->nullable();
            $table->string('address_line2')->nullable();
            $table->string('address_line3')->nullable();
            $table->string('address_city')->nullable();
            $table->string('address_county')->nullable();
            $table->string('address_postcode')->nullable();
            $table->boolean('decision_maker')->nullable();
            $table->boolean('finance_contact')->nullable();
            $table->boolean('technical_contact')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
