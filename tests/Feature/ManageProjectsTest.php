<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_update_a_project()
    {

        $this->signIn();

        $this->withoutExceptionHandling();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);
        
        $this->patch($project->path(), ['notes' => 'changed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'changed']);

    }

    /** @test */
    public function guests_may_not_manage_projects()
    {
        $project = factory('App\Project')->create();
        
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get('/projects')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $attributes = [
            'title'         => $this->faker->sentence,
            'description'   => $this->faker->sentence,
            'notes'         => 'General notes here'
        ];

        $this->get('/projects/create')->assertStatus(200);

        $response = $this->post('/projects', $attributes);
        $this->assertDatabaseHas('projects', $attributes);

        $project = Project::where($attributes)->first();

        $response->assertRedirect($project->path());

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->be(factory('App\User')->create());

        $this->withoutExceptionHandling();

        // GIVEN we have a project
        $project = factory('App\Project')->create(['owner_id' => auth()->user()->id]);

        // WHEN we try to view the project
        // THEN we should see the title and description
        $this->get($project->path())
            ->assertSee($project->title);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others(){

        $this->be(factory('App\User')->create());

        // GIVEN we have a project
        $project = factory('App\Project')->create();

        $this->patch($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others(){

        $this->be(factory('App\User')->create());

        // GIVEN we have a project
        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);
        
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
