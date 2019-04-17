<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDxiLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dxi_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agent_id');
            $table->timestamp('day')->nullable();
            $table->timestamp('first_login')->nullable();
            $table->timestamp('last_logout')->nullable();
            $table->timestamp('first_call')->nullable();
            $table->timestamp('last_call')->nullable();
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
        Schema::dropIfExists('dxi_logins');
    }
}
