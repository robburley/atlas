<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedLineOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_line_opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->integer('lines')->default(0);
            $table->integer('broadband')->default(0);

            $table->string('monthly_spend');
            $table->string('contract_end_date')->index();
            $table->boolean('contract_end_date_confirmed');
            $table->boolean('decide_30_days')->nullable();
            $table->string('type')->nullable();

            $table->text('notes');
            $table->text('current_allowances')->nullable();
            $table->text('current_hardware')->nullable();
            $table->text('new_hardware')->nullable();
            $table->text('requirements')->nullable();
            $table->boolean('qualified')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->text('not_qualified_reason')->nullable();

            $table->boolean('appointment')->default(0);
            $table->boolean('hot_transfer')->nullable();
            $table->boolean('no_bill')->default(0);
            $table->timestamp('no_bill_date')->nullable();
            $table->boolean('valid')->nullable();
            $table->timestamp('validated_at')->nullable();

            $table->boolean('accepted')->nullable()->default(null);
            $table->boolean('provisioned')->default(0);
            $table->text('provisioned_failed_reason')->nullable();
            $table->decimal('gp')->default(0.00);
            $table->boolean('mass_assigned')->default(0);

            $table->integer('fixed_line_opportunity_status_id')->default(1)->unsigned();
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
        Schema::dropIfExists('fixed_line_opportunities');
    }
}
