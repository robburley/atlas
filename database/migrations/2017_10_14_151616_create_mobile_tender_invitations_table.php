<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileTenderInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_tender_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tender_invitation_id');
            $table->integer('allocation_id');
            $table->integer('unit_price')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('lead_time')->nullable();

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
        Schema::dropIfExists('mobile_tender_invitations');
    }
}
