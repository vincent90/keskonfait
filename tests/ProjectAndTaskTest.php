<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProjectAndTaskTest extends TestCase {

    use DatabaseTransactions;

    protected $user;
    protected $user2;

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

    /**
     * @test
     * CT11 – Empêcher la creation d’un projet s'il manque des information critique au projet
     */
    public function do_not_create_a_project_if_needed_field_is_missing()
    {
        $this->get_user();
        $this->actingAs($this->user);
        $this->visit('/projects');
        $this->type('testProject', 'name');
        $this->type('This is a good description for a task', 'description');
        $this->type('1', 'users[]');
        $this->press('Create project');
        $this->see('The start at field is required.');
        $this->see('The end at field is required.');
    }

    /**
     * @test
     * CT10 – Création d’un projet
     */
    public function create_project()
    {
        $this->user2 = factory(App\User::class)->create();
        $this->actingAs($this->user2);
        $this->visit('/projects');
        $this->type('testProject', 'name');
        $this->type('This is a test project', 'description');
        $this->type('2017-05-25', 'start_at');
        $this->type('2017-07-25', 'end_at');
        $this->select([4, 1], 'users[]');
        $this->press('Create project');
        $this->see('testProject');
        $this->see('This is a test project');
        $this->see($this->user2->last_name);
        $this->visit('/projects');
        $this->see('testProject');
        $this->see($this->user2->last_name);
    }

    /**
     * @test
     * CT14 – Historique des changements
     */
    public function check_changes_history()
    {
        $user = DB::table('users')->where('first_name', 'Anthony')->first();
        $project = DB::table('projects')->where('user_id', $user->id)->first();
        $this->visit(route('login'));
        $this->type($user->email, 'email');
        $this->type('secret', 'password');
        $this->press('Login');
        $this->seePageIs('/projects');
        $this->visit("/projects/{$project->id}/edit?");
        $this->type("{$project->name}12345", 'name');
        $this->press('Save changes');
        $this->see("projects/{$project->id}");
        $this->see('Project has been edited successfully!');
        $this->see("{$user->first_name} {$user->last_name}");
        $this->see('changed name from');
        $this->see("{$project->name}");
        $this->see("to");
        $this->see("{$project->name}12345");
    }

//    /** @test */
//    public function delete_project()
//    {
//        $user = factory(App\User::class)->make();
//        $this->actingAs($user);
//        $this->visit('/projects/');
//        $this->press('Delete');
//        $this->press('Delete');
//        $this->type('testProject', 'name');
//        $this->type('This is a test project', 'description');
//        $this->type('2017-05-25', 'start_at');
//        $this->type('2017-07-25', 'end_at');
//        $this->select([4, 1], 'users[]');
//        $this->press('Create project');
//        $this->see('testProject');
//        $this->see('This is a test project');
//        $this->see('Bob Afett');
//        $this->visit('/projects');
//        $this->see('testProject');
//        $this->see('Bob Afett');
//    }


//    /** @test */
//    public function create_task_for_a_project()
//    {
//        $user = DB::table('users')->where('first_name', 'Anthony')->first();
//        var_dump($user->id);
//        $project = DB::table('projects')->where('user_id', $user->id)->first();
//        var_dump($project);
//        $this->visit(route('login'));
//        $this->type($user->email, 'email');
//        $this->type('secret', 'password');
//        $this->press('Login');
//        $this->seePageIs('/projects');
//        $this->visit("/projects/{$project->id}");
//        $this->click('quaerat');
//        $this->visit("/projects/{$project->id}");
//        $this->seePageIs('/projects');
//        $this->see($project->name);
//    }


//    /** @test */
//    public function check_creation_of_a_new_task() {
//        $this->get_user();
//        $this->actingAs($this->user);
//        $this->visit('/projects');
//        $this->see('testProject');
//        $this->see('Bob Afett');
//        $this->visit('/projects');
//        $this->click('testProject');
//        $this->type('testTask1', 'name');
//        $this->type('1', 'task_id');
//        $this->type('This is a good description for a task.', 'description');
//        $this->type('2017-05-29', 'start_at');
//        $this->type('2017-06-22', 'end_at');
////        $this->type('1', 'user_id');
//        $this->type('Open', 'status');
//        $this->press('Create task');
//        $this->see('Task has been created successfully!');
////        $this->see('Anthony Martin Coallier');
//    }

}
