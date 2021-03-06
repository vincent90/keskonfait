<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class AuthTest extends TestCase {

    use DatabaseTransactions;

    protected $user;

    public function get_user() {
        if ($this->user)
            return;

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

    /**
     * @test
     * CT6 – S’assurer que la connexion d’un usager se fait sans problème
     */
    public function a_user_can_successfully_log_in() {
        $this->get_user();
        $this->visit(route('login'));
        $this->type('boba@fett.com', 'email');
        $this->type('123456', 'password');
        $this->press('Login');
        $this->seePageIs('/projects');
    }

    /**
     * @test
     * CT8 – S’assurer qu’un mauvais mot de passe empêche la connexion
     */
    public function a_user_receives_errors_for_wrong_login_credentials() {
        $this->visit(route('login'));
        $this->type('shreder@ninjaturtles.com', 'email');
        $this->type('i_want_to_kill_the_ninja_turtles', 'password');
        $this->press('Login');
        $this->see('These credentials do not match our records.');
    }

    /**
     * @test
     *
     */
    public function a_user_is_redirected_to_dashboard_if_logged_in_and_tries_to_access_login_page() {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit(route('login'));
        $this->seePageIs('/projects');
    }

    /**
     * @test
     * CT7 – S’assurer que l’utilisateur peut changer son mot de passe en cas d’oublie
     */
    public function a_user_can_change_his_password() {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit("/projects");
        $this->click('Update my password');
        $this->seePageIs("/users/{$this->user->id}/edit_password");
        $this->type('123456','old_password');
        $this->type('123456','password');
        $this->type('123456','password_confirmation');
        $this->press("Save new password");
        $this->seePageIs("/users/{$this->user->id}/");
        $this->see('Your password has been updated successfully!');
    }

}
