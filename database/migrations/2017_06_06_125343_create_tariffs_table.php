<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tariff_type_id');
            $table->string('tariff_code')->nullable();
            $table->string('uk_minutes')->nullable();
            $table->string('uk_texts')->nullable();
            $table->string('eu_minutes')->nullable();
            $table->string('eu_texts')->nullable();
            $table->string('eu_data')->nullable();
            $table->string('uk_to_eu_minutes')->nullable();
            $table->integer('price')->default(0);
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('tariffs');
    }
}
