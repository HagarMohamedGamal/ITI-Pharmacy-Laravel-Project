<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pharmacy;
use Faker\Generator as Faker;

$factory->define(Pharmacy::class, function (Faker $faker) {
    // return [
        return [
            // 'id' => $faker->unique($reset = true)->buildingNumber,
            'national_id' => $faker->uuid,
            'avatar' => "default.jpg",
            'area_id' => $faker->uuid,
            'priority' => $faker->randomDigit
        ];
    // ];
});
