<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Task;
use App\Project;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    function it_has_a_path()
    {
        $task = factory(Task::class)->create(['body' => 'some body']);

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path() );
    }    

    /** @test */
    function a_task_belongs_to_a_project()
    {
        $task = factory(Task::class)->create(['body' => 'some body']);

        $this->assertInstanceOf('App\Project', $task->project);
    }    

}
