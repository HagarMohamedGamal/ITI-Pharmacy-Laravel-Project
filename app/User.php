<?php

namespace App;

use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\VerifyApiEmail;
use App\Notifications\notifyUserOrder;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\GreetVerification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\InactiveUserNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','typeable_type','typeable_id', 'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function greetingUser(){
        $this->notify(new GreetVerification);
    }

    public function alterUser(){
        $this->notify(new InactiveUserNotification);
    }

    /**
     * Get the owning typeable model.
     */
    public function typeable()
    {
        return $this->morphTo();
    }

    public function sendApiEmailVerificationNotification()
    {
        $this->notify(new VerifyApiEmail); // my notification
    }

    public function notifyOrder($orderId)
    {
        $this->notify(new notifyUserOrder($orderId)); // my notification
    }

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dateFormat = 'd m Y';
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->isoFormat('LLL');
    }
    // public function setCreatedAtAttribute($value)
    // {
    //     $this->attributes['created_at'] = Carbon::createFromFormat('Y-m-d\TH:i:s.0000000 Z', $value);
    // }
    
}
