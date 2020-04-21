<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Brackets\AdminAuth\Models\AdminUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
    ];
});

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Activity::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->catchPhrase,
        'starts_at' => $faker->dateTime,
        'ends_at' => $faker->dateTime,
        'content' => $faker->text(),
        'quota' => $faker->randomNumber(2),
    ];
});

$factory->state(App\Models\Activity::class, 'ongoing', static function (Faker\Generator $faker) {
    return [
        'starts_at' => $faker->dateTimeBetween('-2 years', 'now'),
        'ends_at' => $faker->dateTimeBetween('now', '+2 years'),
    ];
});

$factory->state(App\Models\Activity::class, 'past', static function (Faker\Generator $faker) {
    return [
        'starts_at' => $faker->dateTimeBetween('-2 years', 'now'),
        'ends_at' => $faker->dateTimeBetween('-1 years', 'now'),
    ];
});

$factory->state(App\Models\Activity::class, 'upcoming', static function (Faker\Generator $faker) {
    return [
        'starts_at' => $faker->dateTimeBetween('now', '+1 years'),
        'ends_at' => $faker->dateTimeBetween('+1 years', '+2 years'),
    ];
});


/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Attendance::class, static function (Faker\Generator $faker) {
    return [
        'arrived_at' => $faker->dateTime,
        'left_at' => $faker->dateTime,
        'activity_id' => $faker->sentence,
        'user_id' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Participant::class, static function (Faker\Generator $faker) {
    return [
        'enrolled_at' => $faker->dateTime,
        'activities_id' => $faker->sentence,
        'user_id' => $faker->sentence,
        'attendance_id' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Participant::class, static function (Faker\Generator $faker) {
    return [
        'enrolled_at' => $faker->dateTime,
        'activity_id' => $faker->sentence,
        'user_id' => $faker->sentence,
        'attendance_id' => $faker->sentence,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\BudgetCategory::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Budget::class, static function (Faker\Generator $faker) {
    return [
        'activity_id' => $faker->sentence,
        'budget_category_id' => $faker->sentence,
        'budget' => $faker->randomNumber(5),
        'expense' => $faker->randomNumber(5),
        'name' => $faker->firstName,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
