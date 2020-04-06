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
        factory(App\Pharmacy::class, 30 )->create()->each(function($pharmacy){
        	$pharmacy->type()->save(factory(App\User::class)->create());
        });
    }
}
