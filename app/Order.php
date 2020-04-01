<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'id',
        'order_user_name',
        'delivering_address',
        'doctor_name',
        'is_insured',
        'status',
        'creator_type',
        'assigned_pharmacy_name',
        'Actions',
    ];
}
