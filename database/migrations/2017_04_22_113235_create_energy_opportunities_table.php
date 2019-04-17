<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnergyOpportunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('energy_opportunities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->decimal('monthly_spend')->default(0.00);
            $table->integer('number_of_sites')->default(1);
            $table->string('looking_for_prices');
            $table->string('direct_or_broker');
            $table->string('typical_contact_length');
            $table->string('supplier_to_avoid');
            $table->boolean('energy_procurement')->default(0);
            $table->boolean('price_comparison')->default(0);
            $table->boolean('kva_mapping_report')->default(0);
            $table->boolean('contract_validation')->default(0);
            $table->boolean('energy_audit')->default(0);
            $table->text('notes');

            $table->boolean('qualified')->nullable();
            $table->timestamp('qualified_at')->nullable();
            $table->text('not_qualified_reason')->nullable();
            $table->boolean('valid')->nullable();
            $table->boolean('accepted')->nullable()->default(null);
            $table->decimal('gp')->default(0.00);
            $table->integer('energy_opportunity_status_id')->default(1)->unsigned();
            $table->foreign('energy_opportunity_status_id')->references('id')->on('energy_opportunity_statuses');
            $table->dateTime('status_updated_at')->default(DB::raw('CURRENT_TIMESTAMP '));
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
        Schema::dropIfExists('energy_opportunities');
    }
}
