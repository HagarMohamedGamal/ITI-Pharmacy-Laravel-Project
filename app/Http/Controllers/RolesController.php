<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesController extends Controller
{
    public function create()
    {
        // $roleDoctor = Role::create(['name'=>'doctor']);
        // $rolePharmacy=Role::create(['name'=>'pharmacy']);
        // $roleClient = Role::create(['name'=>'client']);
        // $roleAdmin=Role::create(['name'=>'admin']);
        // $roleSuperAdmin=Role::create(['name'=>'super-admin']);
        
        // // $permCreateDoctor = Permission::create(['name'=>'create doctor']);
        // $permUpdateDoctor = Permission::create(['name'=>'update doctor']);
        // // $permDeleteDoctor = Permission::create(['name'=>'delete doctor ']);
        // // $permBanDoctor = Permission::create(['name'=>'ban doctor']);

        // // $permCreatePharmacy = Permission::create(['name'=> 'create pharmacy']);
        // $permUpdatePharmacy = Permission::create(['name'=>'update pharmacy']);
        // // $permDeletePharmacy = Permission::create(['name'=> 'delete pharmacy ']);

        // // $roleDoctor->givePermissionTo($permUpdateDoctor, $rolePharmacy);
        // $permUpdateDoctor->syncRoles($roleDoctor, $rolePharmacy);
        // $permUpdatePharmacy->assignRole($rolePharmacy);

         $user =User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('012345'),

        ]);

        $user->refresh();
        $user->assignRole('super-admin');

        
        return redirect('/');
        
    }
}
