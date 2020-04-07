<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'useraddress_id',
        'doctor_id',
        'is_insured',
        'status',
        'creator_type',
        'pharmacy_id',
        'Actions',
    ];

    public function medicines()
    {
        return $this->belongsToMany(Medicine::class)->withTimestamps();
    }
    public function images()
    {
        return $this->hasMany('App/OrderImage');
    }
}
