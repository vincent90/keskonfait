<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectAndTaskTest extends TestCase {

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
    public function check_tasks_for_a_new_user() {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit('/tasks');
        $this->see('Move Along, Nothing to See Here!');
    }

    /** @test */
    public function do_not_create_a_project_if_needed_field_is_missing()
    {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit('/projects');
        $this->type('testProject1', 'name');
        $this->type('This is a good description for a task', 'description');
        $this->type('1', 'users[]');
        $this->press('Create project');
        $this->see('The start at field is required.');
        $this->see('The end at field is required.');
    }

    /** @test */
    public function create_project()
    {
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
        $this->see('This is a test project');
        $this->see('Bob Afett');
        $this->visit('/projects');
        $this->see('testProject');
        $this->see('Bob Afett');
    }

}
