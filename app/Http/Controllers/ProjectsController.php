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

    public function store()
    {
        // persist
        auth()->user()->projects()->create(request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]));

        // redirect
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        if(auth()->user()->isNot($project->owner)){
            abort(403);
        }

        return view('projects.show', compact('project'));
    }
}
