<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('voice_users')->default('0');
            $table->string('data_users')->default('0');
            $table->string('monthly_spend');
            $table->string('contract_end_date')->index();
            $table->boolean('contract_end_date_confirmed');
            $table->string('direct_dealer')->nullable();
            $table->boolean('decide_30_days')->nullable();
            $table->boolean('take_new_number')->nullable();
            $table->string('roaming_international')->nullable();
            $table->text('notes');
            $table->text('current_allowances')->nullable();
            $table->text('current_hardware')->nullable();
            $table->text('new_hardware')->nullable();
            $table->text('requirements')->nullable();
            $table->boolean('qualified')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->text('not_qualified_reason')->nullable();
            $table->boolean('valid')->nullable();
            $table->boolean('accepted')->nullable()->default(null);
            $table->boolean('credit_check')->default(0);
            $table->text('credit_check_failed_reason')->nullable();
            $table->decimal('gp')->default(0.00);
            $table->integer('mobile_opportunity_status_id')->default(1)->unsigned();
            $table->foreign('mobile_opportunity_status_id')->references('id')->on('mobile_opportunity_statuses');
            $table->dateTime('status_updated_at')->default(DB::raw('CURRENT_TIMESTAMP '));
            $table->boolean('recovered')->default(0);
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('mobile_opportunities');
    }
}
