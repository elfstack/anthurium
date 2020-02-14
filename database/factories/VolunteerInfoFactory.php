<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(App\Models\VolunteerInfo::class, function (Faker $faker) {
    return [
        'id_number' => $faker->unique()->ssn,
        'alias' => $faker->firstName,
        'gender' => $faker->randomElement(['Female', 'Male', 'Other']),
        'birthday' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'education' => 'Bachelor',
        'organisation' => $faker->company,
        'mobile_number' => ltrim($faker->e164PhoneNumber, '+'),
        'address' => $faker->address,
        'interests' => $faker->jobTitle,
        'emergency_contact' => $faker->e164PhoneNumber,
        'volunteer_experences' => $faker->sentence,
        'references' => $faker->name
    ];
});
