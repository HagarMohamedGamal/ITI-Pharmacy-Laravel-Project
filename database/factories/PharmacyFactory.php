<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Pharmacy;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Pharmacy::class, function (Faker $faker) {
    // return [
        return [
            'national_id' => $faker->uuid,
            'avatar' => Str::random(10),
            'area_id' => $faker->uuid,
            'priority' => $faker->randomDigit
        ];
    // ];
});
