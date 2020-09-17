<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Models\Budget::class, function (Faker $faker) {
    return [
        'type' => $faker->randomElement(['income', 'expense']),
        'item' => $faker->jobTitle,
        'budget' => $faker->randomFloat(2, 0,999999),
        'actual' => $faker->randomFloat(2, 0,999999),
    ];
});
