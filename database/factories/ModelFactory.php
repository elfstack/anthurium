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
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'email' => $faker->email,
        'email_verified_at' => $faker->dateTime,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VolunteerInfo::class, static function (Faker\Generator $faker) {
    return [
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Activity::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'starts_at' => $faker->dateTime,
        'ends_at' => $faker->dateTime,
        'content' => $faker->text(),
        'quota' => $faker->randomNumber(5),
        
        
    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VolunteerInfo::class, static function (Faker\Generator $faker) {
    return [
        'user_id' => $faker->sentence,
        'id_number' => $faker->sentence,
        'alias' => $faker->sentence,
        'gender' => $faker->sentence,
        'birthday' => $faker->date(),
        'education' => $faker->sentence,
        'organisation' => $faker->sentence,
        'mobile_number' => $faker->sentence,
        'address' => $faker->sentence,
        'interests' => $faker->sentence,
        'emergency_contact' => $faker->sentence,
        'volunteer_experences' => $faker->sentence,
        'references' => $faker->sentence,
        
        
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
