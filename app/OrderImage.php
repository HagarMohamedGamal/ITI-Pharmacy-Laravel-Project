<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    protected $fillable = [ 'image'];
    public $timestamps = false;
    
	public function order()
    {
    	return $this->belongsTo(Order::class);
    }
}
