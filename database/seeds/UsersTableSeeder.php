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
            'name' => 'Anthony',
            'email' => 'anthony@email.com',
            'password' => bcrypt('123456'),
        ]);

        // create 50 dummy accounts
        factory(User::class, 50)->create();
    }

}
