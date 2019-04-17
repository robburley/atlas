<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConditionalFieldsToCashFlowItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cash_flow_items', function (Blueprint $table) {
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->timestamp('declined_at')->nullable();
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
