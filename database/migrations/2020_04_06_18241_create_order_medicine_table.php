<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMedicineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medicine_order', function (Blueprint $table) {

            $table->unsignedInteger('order_id');
            $table->unsignedInteger('medicine_id');
            $table->timestamps();
        });
    }
}
