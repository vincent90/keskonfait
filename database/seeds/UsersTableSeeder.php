<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        DB::table('users')->insert([
            'first_name' => 'Anthony',
            'last_name' => 'Martin Coallier',
            'phone_number' => '(555) 555-5555',
            'user_image' => '1.jpg',
            'email' => 'meweddolinn-0408@yopmail.com',
            'superuser' => true,
            'password' => bcrypt('123456'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'Butter',
            'last_name' => 'Turtle',
            'phone_number' => '(666) 666-6666',
            'user_image' => '2.jpg',
            'email' => 'attopaxah-2173@yopmail.com',
            'superuser' => false,
            'password' => bcrypt('123456'),
        ]);

        $faker = Faker\Factory::create();

        // Create 10 dummy accounts with user images.
        for ($i = 3; $i < 13; $i++) {
            App\User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone_number' => $faker->phoneNumber,
                'user_image' => $i . '.jpg',
                'email' => $faker->unique()->safeEmail,
                'superuser' => false,
                'password' => bcrypt('123456'),
                'remember_token' => str_random(10),
            ]);
        }

        // Create 10 dummy accounts without user images.
        for ($i = 0; $i < 10; $i++) {
            App\User::create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'phone_number' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'superuser' => false,
                'password' => bcrypt('123456'),
                'remember_token' => str_random(10),
            ]);
        }
    }

}
