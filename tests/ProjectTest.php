<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class ProjectTest extends TestCase {

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

    /** @test */
    public function create_project() {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit('/projects');
        $this->type('testProject', 'name');
        $this->type('This is a test project', 'description');
        $this->type('2017-05-25', 'start_at');
        $this->type('2017-07-25', 'end_at');
        $this->select([4, 1], 'users[]');
        $this->press('Create project');
        $this->see('testProject');
    }

}
