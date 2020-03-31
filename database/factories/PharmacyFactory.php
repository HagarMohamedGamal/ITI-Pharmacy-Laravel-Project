<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pharmacy;
use Faker\Generator as Faker;

$factory->define(Pharmacy::class, function (Faker $faker) {
    // return [
        return [
            // 'id' => $faker->unique($reset = true)->buildingNumber,
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail,
            'national_id' => $faker->uuid,
            'avatar' => $faker->image,
            'area_id' => $faker->uuid,
            'priority' => $faker->randomDigit
        ];
    // ];
});
