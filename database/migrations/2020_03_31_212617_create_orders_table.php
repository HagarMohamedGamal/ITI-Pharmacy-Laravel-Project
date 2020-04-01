<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_user_name', 100);	
            $table->string('delivering_address', 100);	
            $table->string('doctor_name', 100);	
            $table->boolean('is_insured');
            $table->string('status', 100);	
            $table->string('creator_type', 100);
            $table->string('assigned_pharmacy_name', 100);
            $table->string('Actions', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
