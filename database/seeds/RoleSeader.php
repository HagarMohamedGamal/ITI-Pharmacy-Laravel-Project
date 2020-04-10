<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class RoleSeader extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleDoctor = Role::create(['name' => 'doctor']);
        $rolePharmacy = Role::create(['name' => 'pharmacy']);
        $roleClient = Role::create(['name' => 'client']);
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        $permUpdateDoctor = Permission::create(['name' => 'update doctor']);
        $permUpdatePharmacy = Permission::create(['name' => 'update pharmacy']);
        $permUpdateDoctor->syncRoles($roleDoctor, $rolePharmacy);
        $permUpdatePharmacy->assignRole($rolePharmacy);

        

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('012345'),
            'email_verified_at' => now()->toDateTimeString(),

        ]);

        $user->refresh();
        $user->assignRole('super-admin');
        // Auth::login($user);
    }
}
