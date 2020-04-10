<?php

use App\User;
use Illuminate\Database\Seeder;

class AssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('typeable_type', 'App\Client')->get();
        foreach ($users as $user) {
            $user->assignRole('client');
            
        }

        $users = User::where('typeable_type', 'App\Doctor')->get();
        foreach ($users as $user) {
            $user->assignRole('doctor');
        }

        $users = User::where('typeable_type', 'App\Pharmacy')->get();
        foreach ($users as $user) {
            $user->assignRole('pharmacy');
        }
    }
}
