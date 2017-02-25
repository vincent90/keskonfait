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
    $start_at = (new Carbon())->addDays(rand(0, 30));
    $end_at = $start_at->copy()->addDays(rand(60, 80));

    return [
        'name' => $faker->sentence(rand(5, 15)),
        'description' => $faker->sentence(rand(0, 100)),
        'start_at' => $start_at->toDateString(),
        'end_at' => $end_at->toDateString(),
    ];
});
