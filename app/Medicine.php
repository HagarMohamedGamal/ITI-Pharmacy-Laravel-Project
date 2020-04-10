<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $fillable = ['name', 'type', 'price'];
    
    public function getPriceAttribute(){
        return $this->attributes['price'] /100;
    }
    public function setPriceAttribute($val){
        $this->attributes['price'] = $val * 100;
    }
    

    public function orders()
    {
        return $this->belongsToMany('App\Order');
    }
    
}
