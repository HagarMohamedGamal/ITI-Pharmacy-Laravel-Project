<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
            'national_id' => $faker->randomNumber($nbDigits = NULL, $strict = false),
            'avatar' => Str::random(10),
            'gender' => $faker->title($gender = 'male'|'female') ,
            'birth_day' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'mobile'  => $faker->randomNumber($nbDigits = NULL, $strict = false),
    ];
});
