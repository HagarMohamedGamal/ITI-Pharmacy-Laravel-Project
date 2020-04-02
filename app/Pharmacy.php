<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'email', 'national_id', 'avatar', 'area_id', 'priority'];
    public $timestamps = false;
}
