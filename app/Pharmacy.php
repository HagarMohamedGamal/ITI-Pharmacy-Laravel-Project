<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    protected $fillable = ['name', 'email', 'national_id', 'avatar', 'area_id', 'priority'];
    public $timestamps = false;
}
