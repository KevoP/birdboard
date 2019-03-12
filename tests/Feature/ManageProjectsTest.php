<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

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
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];

        $this->get('/projects/create')->assertStatus(200);

        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
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
            // ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_vew_the_projects_of_others(){

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
