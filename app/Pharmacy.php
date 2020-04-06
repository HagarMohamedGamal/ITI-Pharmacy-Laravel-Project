<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pharmacy extends Model
{
    use SoftDeletes;
    protected $fillable = [ 'national_id', 'avatar', 'area_id', 'priority'];
    public $timestamps = false;

    /**
     * Get the pharmacy user.
     */
    public function type()
    {
        return $this->morphOne('App\User', 'typeable');
    }

    /**
     * Get the doctors for the blog post.
     */
    public function doctors()
    {
        return $this->hasMany('App\Doctor');
    }
   
}
