<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for ($i=0; $i < 100; $i++)
       {
            DB::table('orders')->insert([
                'user_id' => rand(1,10),
                'useraddress_id' => rand(1, 10),
                'doctor_id' => rand(1, 10),
                'is_insured'=>(bool)random_int(0, 1),
                'status'=>Str::random(10),
                'creator_type'=>Str::random(10),
                'pharmacy_id' => rand(1, 10),
                'Actions' => Str::random(10),
            ]);
       }
    }
}
