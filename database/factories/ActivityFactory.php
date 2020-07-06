<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Activity;
use Faker\Generator as Faker;

$factory->define(Activity::class, static function (Faker $faker) {
    return [
        'name' => $faker->catchPhrase,
        'starts_at' => $faker->dateTime,
        'ends_at' => $faker->dateTime,
        'content' => $faker->text(),
        'quota' => $faker->randomNumber(2),
    ];
});

$factory->state(Activity::class, 'ongoing', static function (Faker $faker) {
    return [
        'starts_at' => $faker->dateTimeBetween('-2 years', 'now'),
        'ends_at' => $faker->dateTimeBetween('now', '+2 years'),
        'is_published' => $faker->randomElement([true, false])
    ];
});

$factory->state(Activity::class, 'past', static function (Faker $faker) {
    return [
        'starts_at' => $faker->dateTimeBetween('-2 years', 'now'),
        'ends_at' => $faker->dateTimeBetween('-1 years', 'now'),
        'is_published' => $faker->randomElement([true, false])
    ];
});

$factory->state(Activity::class, 'upcoming', static function (Faker $faker) {
    return [
        'starts_at' => $faker->dateTimeBetween('now', '+1 years'),
        'ends_at' => $faker->dateTimeBetween('+1 years', '+2 years'),
        'is_published' => true
    ];
});
