<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function ($table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email');
            $table->string('national_id');
            $table->string('avatar')->nullable();
            $table->string('area_id');
            $table->integer('priority');
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
