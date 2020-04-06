<?php

use Illuminate\Database\Seeder;

class PharmaciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pharmacy::class, 10)->create()->each(function ($pahrmacy) {
            $pahrmacy->type()->save(factory(App\User::class)->create());
        });
    }
}
