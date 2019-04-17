<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_notes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->nullable()->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->integer('customer_note_type_id')->unsigned();
            $table->foreign('customer_note_type_id')->references('id')->on('customer_note_types');
            $table->text('body');
            $table->boolean('pinned')->default(0);
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('notable_id')->nullable()->unsigned();
            $table->string('notable_type')->nullable();

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
        Schema::dropIfExists('customer_notes');
    }
}
