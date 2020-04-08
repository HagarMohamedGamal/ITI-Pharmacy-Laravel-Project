<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pharmacy;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Pharmacy::class, function (Faker $faker) {
    // return [
        return [
            // 'id' => $faker->unique($reset = true)->buildingNumber,
            'national_id' => $faker->uuid,
            'avatar' => "default.jpg",
            'area_id' => $faker->numberBetween($min = 1, $max = 2),
            'priority' => $faker->numberBetween($min = 1, $max = 10),
        ];
    // ];
});
