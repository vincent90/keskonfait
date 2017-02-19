<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

        // Create a test account.
        DB::table('users')->insert([
            'first_name' => 'Anthony',
            'last_name' => 'Martin Coallier',
            'phone_number' => '(555) 555-5555',
            'user_image' => '1.jpg',
            'discord_user' => '269612768452280320',
            'discord_channel' => '281588227343777792',
            'email' => 'anthony.martin-coallier.1@etsmtl.net',
            'superuser' => true,
            'active' => true,
            'password' => bcrypt('123456'),
        ]);

        // Create 10 normal users.
        factory(App\User::class, 10)->create([
            'discord_channel' => '281588227343777792',])->each(function ($user) {
            $user->projects()->save(factory(App\Project::class)->make([
                        'user_id' => $user->id,]));
        });

        // Create 3 super users.
        factory(App\User::class, 'superuser', 3)->create([
            'discord_channel' => '281588227343777792',])->each(function ($user) {
            $user->projects()->save(factory(App\Project::class)->make([
                        'user_id' => $user->id,]));
        });

        // Create 3 deactivated users.
        factory(App\User::class, 'inactive', 3)->create([
            'discord_channel' => '281588227343777792',])->each(function ($user) {
            $user->projects()->save(factory(App\Project::class)->make([
                        'user_id' => $user->id,]));
        });
    }

}
