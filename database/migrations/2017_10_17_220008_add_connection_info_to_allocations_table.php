<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConnectionInfoToAllocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('allocations', function (Blueprint $table) {
            $table->string('account_number')->nullable();
            $table->timestamp('date_connected')->nullable();
            $table->timestamp('contract_end_date')->nullable();
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
