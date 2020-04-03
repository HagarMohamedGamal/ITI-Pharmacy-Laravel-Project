<?php

namespace App;
use Cog\Contracts\Ban\Bannable as BannableContract;
use Cog\Laravel\Ban\Traits\Bannable;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model implements BannableContract
{
    use Bannable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'national_id', 'avatar', 'pharmacy_name', 'is_baned'
    ];
}
