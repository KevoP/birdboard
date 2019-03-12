<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ProjectTasksTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project =  auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $this->post($project->path() . '/tasks', ['body' => 'text here']);

        $this->get($project->path())
            ->assertSee('text here');   
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $this->signIn();

        $project =  auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory('App\Task')->raw(['body' => '']);
        
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

}
