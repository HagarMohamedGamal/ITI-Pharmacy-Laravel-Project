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
         'national_id', 'avatar', 'pharmacy_name', 'is_baned',''
    ];

    /**
     * Get the doctor user.
     */
    public function type()
    {
        return $this->morphOne('App\User', 'typeable');
    }

    /**
     * Get the pharmacy for the blog post.
     */
    public function pharmacy()
    {
        return $this->belongsTo('App\Pharmacy');
    }

    public $timestamps = false;
}
