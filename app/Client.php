<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    protected $fillable = [
        'name', 'email', 'password','gender','mobile','avatar','national_id','birth_day','password',
    ];




}

