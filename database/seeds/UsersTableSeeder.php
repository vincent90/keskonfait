<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $discord_channel = config('app.discord_channel_for_seeds');

        // Create a test account.
        factory(App\User::class, 'superuser')->create([
            'first_name' => 'Anthony',
            'last_name' => 'Martin Coallier',
            'phone_number' => '(555) 555-5555',
            'user_image' => '1.jpg',
            'discord_user' => '269612768452280320',
            'discord_channel' => $discord_channel,
            'email' => 'anthony.martin-coallier.1@etsmtl.net',
            'superuser' => true,
            'active' => true,
            'password' => bcrypt('123456'),
        ])->each(function ($user) {
            $user->projects()->saveMany(factory(App\Project::class, rand(2, 4))->make([
                        'user_id' => $user->id,]));
        });

        // Create 15 normal users and a few projects for each.
        factory(App\User::class, 15)->create([
            'discord_channel' => $discord_channel,])->each(function ($user) {
            $user->projects()->saveMany(factory(App\Project::class, rand(2, 4))->make([
                        'user_id' => $user->id,]));
        });

        // Create 5 super users and a few projects for each.
        factory(App\User::class, 'superuser', 5)->create([
            'discord_channel' => $discord_channel,])->each(function ($user) {
            $user->projects()->saveMany(factory(App\Project::class, rand(2, 4))->make([
                        'user_id' => $user->id,]));
        });

        // Create 5 deactivated users and a few projects for each.
        factory(App\User::class, 'inactive', 5)->create([
            'discord_channel' => $discord_channel,])->each(function ($user) {
            $user->projects()->saveMany(factory(App\Project::class, rand(2, 4))->make([
                        'user_id' => $user->id,]));
        });
    }

}
