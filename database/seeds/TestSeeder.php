<?php

use App\Area;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            ['name' => 'eldekhela', 'address' => 'alex'],
            ['name' => 'betash', 'address' => 'alex']
        ]);

        DB::table('user_addresses')->insert([
            ['area_id' => 1, 'street_name' => 'nagy',
                'build_no' => 10, 'floor_no' => 5,
                'flat_no' => 13, 'is_main' => 1, 'client_id' => 1],
            [
                'area_id' => 2, 'street_name' => 'mtafy',
                'build_no' => 12, 'floor_no' => 4,
                'flat_no' => 15, 'is_main' => 0, 'client_id' => 1
            ],
            [
                'area_id' => 1, 'street_name' => 'talkhawy',
                'build_no' => 9, 'floor_no' => 3,
                'flat_no' => 18, 'is_main' => 1, 'client_id' => 2
            ],
            [
                'area_id' => 2, 'street_name' => 'mtafy',
                'build_no' => 12, 'floor_no' => 4,
                'flat_no' => 15, 'is_main' => 0, 'client_id' => 2
            ],
        ]);

        






       
    }
}
