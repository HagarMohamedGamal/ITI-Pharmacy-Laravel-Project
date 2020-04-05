<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable=[
        'area_id','street_name','build_no','floor_no','flat_no','is_main'
    ];

    public function area()
    {
        return $this->belongsTo('App\Area');
    }
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
