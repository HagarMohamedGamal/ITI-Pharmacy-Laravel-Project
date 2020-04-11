<?php

namespace App\Policies;

use App\Order;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Doctor;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function view(User $user, Order $order)
    {
        if ($user->hasRole('doctor'))
        {
            $doctor = Doctor::find($user->typeable_id);
            $result = $doctor->pharmacy_id == $order->pharmacy_id ? true : false ;
        }
       return ($user->typeable_id === $order->pharmacy_id) || ($user->typeable_id === $order->doctor_id) || $user->hasRole('super-admin') ||$result;
        
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function update(User $user, Order $order)
    {
        if ($user->hasRole('doctor')) {
            $doctor = Doctor::find($user->typeable_id);
            $result = $doctor->pharmacy_id == $order->pharmacy_id ? true : false;
        }
        return ($user->typeable_id === $order->pharmacy_id) ||
         ($user->typeable_id === $order->doctor_id) ||
          ($user->typeable_id === $order->user_id) || $user->hasRole('super-admin')|| $result;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function delete(User $user, Order $order)
    {

        if ($user->hasRole('doctor')) {
            $doctor = Doctor::find($user->typeable_id);
            $result = $doctor->pharmacy_id == $order->pharmacy_id ? true : false;
        }

        return ($user->typeable_id === $order->pharmacy_id) || $result ||
          ($user->typeable_id === $order->user_id) || $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function restore(User $user, Order $order)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Order  $order
     * @return mixed
     */
    public function forceDelete(User $user, Order $order)
    {
        //
    }
}
