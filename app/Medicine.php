<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{

    public function getPriceAttribute(){
        return $this->attributes['price'] /100;
    }
    public function setPriceAttribute($val){
        $this->attributes['price'] = $val * 100;
    }
    protected $fillable = ['name', 'quantity', 'type', 'price'];

    
}
