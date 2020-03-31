<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','gender','mobile','avatar','national_id','birth_day','password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */


}

