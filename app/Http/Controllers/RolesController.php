<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesController extends Controller
{
    public function create()
    {
        // $roleDoctor = Role::create(['name' => 'doctor']);
        // $rolePharmacy = Role::create(['name' => 'pharmacy']);
        // $roleClient = Role::create(['name' => 'client']);
        // $roleAdmin = Role::create(['name' => 'admin']);
        // $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        // $permUpdateDoctor = Permission::create(['name' => 'update doctor']);
        // $permUpdatePharmacy = Permission::create(['name' => 'update pharmacy']);
        // $permUpdateDoctor->syncRoles($roleDoctor, $rolePharmacy);
        // $permUpdatePharmacy->assignRole($rolePharmacy);

        // ------------------------------------------------------------------

        // // $permCreateDoctor = Permission::create(['name'=>'create doctor']);
       
        // // $permDeleteDoctor = Permission::create(['name'=>'delete doctor ']);
        // // $permBanDoctor = Permission::create(['name'=>'ban doctor']);

        // // $permCreatePharmacy = Permission::create(['name'=> 'create pharmacy']);
       
        // // $permDeletePharmacy = Permission::create(['name'=> 'delete pharmacy ']);

        // // $roleDoctor->givePermissionTo($permUpdateDoctor, $rolePharmacy);
       

        $user = Auth::user();

        if ($user) {
            Auth::logout();
        }

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('012345'),
            'email_verified_at'=> now(),

        ]);

        $user->refresh();
        $user->assignRole('super-admin');
        Auth::login($user);

        return redirect('/');
    }
}
