<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $discord_channel = config('app.discord_channel_for_seeded_users');
        $discord_user_anthony = config('app.discord_user_for_seeded_user_anthony');

        // create a test account for a developer
        factory(App\User::class, 'superuser')->create([
            'first_name' => 'Anthony',
            'last_name' => 'Martin Coallier',
            'discord_user' => $discord_user_anthony,
            'discord_channel' => $discord_channel,
            'email' => 'anthony.martin-coallier.1@etsmtl.net',
            'password' => bcrypt('secret')
        ]);

        // create 15 normal user accounts
        factory(App\User::class, 15)->create([
            'discord_channel' => $discord_channel,]);

        // create 5 superuser accounts
        factory(App\User::class, 'superuser', 5)->create([
            'discord_channel' => $discord_channel,]);

        // create 5 deactivated user accounts
        factory(App\User::class, 'inactive', 5)->create([
            'discord_channel' => $discord_channel,]);
    }

}
