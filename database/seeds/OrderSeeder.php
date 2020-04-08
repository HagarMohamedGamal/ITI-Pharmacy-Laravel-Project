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
                'user_id' => rand(21,30),
                'useraddress_id' => rand(1, 4),
                'doctor_id' => rand(21, 30),
                'is_insured'=>(bool)random_int(0, 1),
                'status'=>'new',
                'creator_type'=>'null',
                'pharmacy_id' => rand(41, 50),
                'Actions' => 'null',
                'price'=> 0
            ]);
       }
    }
}
