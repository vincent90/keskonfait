<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name', 60);
            $table->string('last_name', 100);
            $table->string('phone_number', 30);
            $table->string('user_image')->nullable();
            $table->string('discord_user', 50)->nullable();
            $table->string('discord_channel', 50)->nullable();
            $table->string('email')->unique();
            $table->boolean('superuser')->default(false);
            $table->boolean('active')->default(true);
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('users');
    }

}
