<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Form;
use Faker\Generator as Faker;

$factory->define(Form::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->sentence,
    ];
});
