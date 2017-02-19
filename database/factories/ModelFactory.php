<?php

use Carbon\Carbon;

/*
  |--------------------------------------------------------------------------
  | Model Factories
  |--------------------------------------------------------------------------
  |
  | Here you may define all of your model factories. Model factories give
  | you a convenient way to create models for testing and seeding your
  | database. Just tell the factory how a default model should look.
  |
 */

/**
 * Generate a fake normal user.
 */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone_number' => $faker->phoneNumber,
        'user_image' => rand(1, 12) . '.jpg',
        'email' => $faker->unique()->safeEmail,
        'superuser' => false,
        'active' => true,
        'password' => bcrypt('123456'),
        'remember_token' => str_random(10),
    ];
});

/**
 * Generate a fake super user.
 */
$factory->defineAs(App\User::class, 'superuser', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw('App\User');
    return array_merge($user, ['superuser' => true]);
});

/**
 * Generate a fake inactive user.
 */
$factory->defineAs(App\User::class, 'inactive', function (Faker\Generator $faker) use ($factory) {
    $user = $factory->raw('App\User');
    return array_merge($user, ['active' => false]);
});

/**
 * Generate a fake project.
 */
$factory->define(App\Project::class, function (Faker\Generator $faker) {
    $start_at = Carbon::today()->addDays(rand(0, 5));
    $end_at = Carbon::today()->addWeeks(rand(6, 10));

    return [
        'name' => $faker->sentence(rand(3, 8)),
        'description' => $faker->sentence(rand(1, 5)),
        'start_at' => $start_at,
        'end_at' => $end_at,
    ];
});

/**
 * Generate a fake root task.
 */
$factory->define(App\Task::class, function (Faker\Generator $faker) {
    $start_at = Carbon::today()->addDays(rand(6, 9));
    $end_at = Carbon::today()->addWeeks(rand(1, 3));

    return [
        'name' => $faker->sentence(rand(3, 8)),
        'description' => $faker->sentence(rand(1, 5)),
        'start_at' => $start_at,
        'end_at' => $end_at,
        'status' => 'Open'
    ];
});
