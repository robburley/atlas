<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id');

            $table->string('mobile_status');
            $table->text('mobile_description')->nullable();
            $table->timestamp('mobile_rearranged_at')->nullable();

            $table->string('fixed_line_status');
            $table->text('fixed_line_description')->nullable();
            $table->timestamp('fixed_line_rearranged_at')->nullable();

            $table->string('broadband_status');
            $table->text('broadband_description')->nullable();
            $table->timestamp('broadband_rearranged_at')->nullable();

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
        Schema::dropIfExists('other_services');
    }
}
