<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        // show all for authenticated user
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store()
    {
        // persist
        $project = auth()->user()->projects()->create(
            request()->validate([
                'title'         => 'required',
                'description'   => 'required|max:100',
                'notes'         => 'min:3'
            ])
        );

        // redirect
        return redirect($project->path());
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $validated = request()->validate(['notes' => 'required']);

        // update notes
        $project->update(request(['notes']));

        // redirect to project page
        return redirect($project->path());
    }
}
