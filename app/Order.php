<?php

namespace App;

use Carbon\Carbon;
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
        return $this->belongsToMany(Medicine::class)->withPivot('quantity')->withTimestamps();
    }
    public function images()
    {
        return $this->hasMany(OrderImage::class);
    }
    public function user()
    {
        return $this->belongsTo(Client::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }
    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'useraddress_id');
    }
    public function setCreated_atAttribute($value)
    {
        $this->attributes['created_at'] = $value->toDateString();
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('LLL');
    }


}
