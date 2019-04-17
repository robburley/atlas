<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFixedLineCommercialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fixed_line_commercials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fixed_line_opportunity_id');

            $table->integer('term')->default(0);
            $table->integer('tariff')->default(0);
            $table->integer('setup_install_charges')->default(0);
            $table->integer('admin_charge_confirmed')->default(0);
            $table->integer('broad_band_confirmed')->default(0);
            $table->integer('fibre_broad_band_price')->default(0);
            $table->integer('adsl_broad_band_price')->default(0);
            $table->integer('call_bundle_local_national')->default(0);
            $table->integer('call_bundle_mobile')->default(0);
            $table->integer('custom_local')->nullable();
            $table->integer('custom_national')->nullable();
            $table->integer('custom_vodafone')->nullable();
            $table->integer('custom_o2')->nullable();
            $table->integer('custom_ee')->nullable();
            $table->integer('custom_three')->nullable();
            $table->integer('monthly_line_rental')->default(0);
            $table->integer('monthly_features_rental')->default(0);
            $table->integer('total_monthly_recurring_charges')->default(0);
            $table->integer('total_setup_install_charges')->default(0);
            $table->text('note')->nullable();

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
        Schema::dropIfExists('fixed_line_commercials');
    }
}
