@extends('layouts.app')

@section('content')
    
    <header class="flex items-center mb-3 py-3">
        <div class="flex justify-between w-full items-end">
            <h2 class="text-grey text-sm font-normal">My Projects</h2>

            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <div class="lg:flex lg:flex-wrap -mx-4">

        @forelse($projects as $project)
            <div class="p-4 lg:w-1/3">
                @include('projects.card')
            </div>
        @empty

            <p>No projects found</p>
        
        @endforelse

    </div>

@endsection
