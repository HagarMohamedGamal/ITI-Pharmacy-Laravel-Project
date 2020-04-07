<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        // $this->call(PharmaciesTableSeeder::class);
        // $this->call(DoctorTableSeeder::class);
        $this->call(ClientSeeder::class);
        // $this->call(OrderSeeder::class);
        // $this->call(RoleSeader::class);

    }
}
