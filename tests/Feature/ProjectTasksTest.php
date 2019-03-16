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

    /** @test */
    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $project = factory('App\Project')->create();

        $this->signIn();

        $this->post($project->path() . '/tasks', ['body' => 'new test task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'new test task']);
    }

    /** @test */
    public function only_the_owner_of_a_project_can_update_tasks()
    {
        $project = factory('App\Project')->create();
        $task = $project->addTask('test task');

        $this->signIn();

        $this->patch($task->path(), ['body' => 'patched'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'patched']);
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

        $project =  auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('test task');

        $this->patch($task->path(), [
            'body' => 'new test body', 
            'completed' => true
        ]);
        
        $this->assertDatabaseHas('tasks', ['body' => 'new test body', 'completed' => true]);

    }

}
