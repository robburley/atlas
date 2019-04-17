<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJourneyTeamSurveysTable extends Migration
{
    protected $table = 'journey_team_surveys';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('customer_id')->unsigned();

            $table->boolean('fixed_line_complete')->nullable();
            $table->boolean('energy_complete')->nullable();
            $table->boolean('water_complete')->nullable();
            $table->boolean('it_complete')->nullable();
            $table->boolean('vehicle_tracking_complete')->nullable();
            $table->boolean('mobile_complete')->nullable();

            $table->boolean('mobile_issues')->nullable();
            $table->text('mobile_issues_details')->nullable();

            $table->text('fixed_line_current_supplier')->nullable();
            $table->text('fixed_line_current_contract_remaining')->nullable();
            $table->text('fixed_line_average_monthly_bill')->nullable();
            $table->text('fixed_line_issues')->nullable();
            $table->boolean('fixed_line_review')->nullable();

            $table->text('energy_current_supplier')->nullable();
            $table->text('energy_current_contract_remaining')->nullable();
            $table->text('energy_average_monthly_bill')->nullable();
            $table->text('energy_issues')->nullable();
            $table->boolean('energy_review')->nullable();

            $table->text('water_current_supplier')->nullable();
            $table->text('water_current_contract_remaining')->nullable();
            $table->text('water_average_monthly_bill')->nullable();
            $table->text('water_issues')->nullable();
            $table->boolean('water_review')->nullable();

            $table->text('it_current_supplier')->nullable();
            $table->text('it_current_contract')->nullable();
            $table->text('it_service_level')->nullable();
            $table->text('it_hardware_maintenance_contract_renewal')->nullable();
            $table->boolean('it_review')->nullable();

            $table->text('vehicle_tracking_current_supplier')->nullable();
            $table->text('vehicle_tracking_current_contract_remaining')->nullable();
            $table->text('vehicle_tracking_average_monthly_bill')->nullable();
            $table->text('vehicle_tracking_issues')->nullable();
            $table->boolean('vehicle_tracking_review')->nullable();

            //Files
            $table->string('fixed_line_bill')->nullable();
            $table->boolean('fixed_line_bill_set')->nullable();
            $table->boolean('fixed_line_bill_requirements')->nullable();

            $table->string('energy_bill')->nullable();
            $table->boolean('energy_bill_set')->nullable();
            $table->boolean('energy_bill_requirements')->nullable();

            $table->string('water_bill')->nullable();
            $table->boolean('water_bill_set')->nullable();
            $table->boolean('water_bill_requirements')->nullable();

            $table->string('it_bill')->nullable();
            $table->boolean('it_bill_set')->nullable();
            $table->boolean('it_bill_requirements')->nullable();

            $table->string('vehicle_tracking_bill')->nullable();
            $table->boolean('vehicle_tracking_bill_set')->nullable();
            $table->boolean('vehicle_tracking_bill_requirements')->nullable();


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
        Schema::dropIfExists($this->table);
    }
}
