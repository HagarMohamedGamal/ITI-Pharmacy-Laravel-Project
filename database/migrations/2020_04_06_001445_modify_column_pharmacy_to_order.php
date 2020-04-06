<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnPharmacyToOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_user_name', 'delivering_address', 'doctor_name', 'assigned_pharmacy_name']);
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('useraddress_id');
            $table->unsignedInteger('doctor_id');
            $table->unsignedInteger('pharmacy_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order', function (Blueprint $table) {
            //
        });
    }
}
