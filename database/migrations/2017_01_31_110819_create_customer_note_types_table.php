<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerNoteTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_note_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->index()->unique();
            $table->string('past_tense');
            $table->string('colour')->default('primary');
            $table->string('icon')->default('paper-plane-o');
            $table->string('manual')->default(0);
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
        Schema::dropIfExists('customer_note_types');
    }
}
