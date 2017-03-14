<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;


class AuthTest extends TestCase
{

    use DatabaseTransactions;

    protected $user;

    public function get_user()
    {
        if ($this->user) return;

        $this->user = factory(App\User::class)->create([
            'first_name' => 'Bob',
            'last_name' => 'Afett',
            'phone_number' => '(555) 555-5555',
            'user_image' => '1.jpg',
            'email' => 'boba@fett.com',
            'superuser' => true,
            'password' => bcrypt('123456'),
        ]);
    }

    /** @test */
    public function a_user_can_successfully_log_in()
    {
        $email = 'meweddolinn-0408@yopmail.com';
        $password = '123456';

        $this->visit(route('login'));
        $this->type($email, 'email');
        $this->type($password, 'password');
        $this->press('Login');
        $this->seePageIs('/projects');
    }

    /** @test */
    public function a_user_receives_errors_for_wrong_login_credentials()
    {
        $this->visit(route('login'));
        $this->type('shreder@ninjaturtles.com', 'email');
        $this->type('i_want_to_kill_the_ninja_turtles', 'password');
        $this->press('Login');
        $this->see('These credentials do not match our records.');
    }

    /** @test */
    public function a_user_is_redirected_to_dashboard_if_logged_in_and_tries_to_access_login_page()
    {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit(route('login'));
        $this->seePageIs('/projects');
    }

    /** @test */
    public function check_tasks_for_a_new_user()
    {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit('/tasks');
        $this->see('Move Along, Nothing to See Here!');
    }

}
