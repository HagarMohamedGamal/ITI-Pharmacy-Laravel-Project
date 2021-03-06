<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\DB;

$factory->define(App\Doctor::class, function (Faker $faker) {
    return [
            'national_id' => $faker->randomNumber($nbDigits = NULL, $strict = false),
            'avatar' => 'avatars/default.jpg',
            'pharmacy_id' => $faker->numberBetween($min = 1, $max = 10),
            'is_baned' => $faker->boolean
    ];
});
