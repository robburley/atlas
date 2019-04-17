<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDxiCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dxi_calls', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('day')->nullable();
            $table->string('callid')->nullable();
            $table->string('qid')->nullable();
            $table->string('dataset')->nullable();
            $table->string('urn')->nullable();
            $table->integer('agent')->nullable();
            $table->string('ddi')->nullable();
            $table->string('cli')->nullable();
            $table->string('ringtime')->nullable();
            $table->string('duration')->nullable();
            $table->string('result')->nullable();
            $table->string('outcome')->nullable();
            $table->string('type')->nullable();
            $table->timestamp('datetime')->nullable();
            $table->timestamp('answer')->nullable();
            $table->timestamp('disconnect')->nullable();
            $table->timestamp('last_update')->nullable();
            $table->string('carrier')->nullable();
            $table->string('flags')->nullable();
            $table->string('terminate')->nullable();
            $table->string('customer')->nullable();
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
        Schema::dropIfExists('dxi_calls');
    }
}
