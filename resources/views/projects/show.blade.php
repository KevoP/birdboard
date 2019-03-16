@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 py-3">
        <div class="flex justify-between w-full items-end">
            <p class="text-grey text-sm font-normal">
                <a href="/projects" class="text-grey text-sm font-normal no-underline">My Projects</a> / {{ $project->title }}
            </p>

            <a href="/projects/create" class="button">New Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">

                <section class="mb-8">
                    <h2 class="text-grey text-lg font-normal mb-3">Tasks</h2>
                    {{-- tasks --}}
                    @foreach($project->tasks as $task)
                        <form method="post" action="{{ $task->path() }}" class="flex justify-between items-center card text-grey mb-3">
                            @method('PATCH') @csrf
                            <input type="text" name="body" value="{{ $task->body }}" class="w-full {{ ($task->completed) ? 'text-grey' : '' }}"/>
                            <input type="checkbox" name="completed" value="{{ $task->body }}" onChange="this.form.submit()" {{ ($task->completed) ? 'checked': '' }}/>
                        </form>
                    @endforeach

                    <form method="post" class="card text-grey mb-3" action="/projects/{{$project->id}}/tasks">
                        @csrf
                        <input type="text" name="body" class="w-full" placeholder="Add a task...">
                    </form>
                </section>
                
                <section class="mb-8">
                    <h2 class="text-grey text-lg font-normal mb-3">General Notes</h2>
                    
                    {{-- general notes --}}
                    <textarea class="card w-full text-grey" style="height: 200px;">Lorem Ipsum</textarea>
                </section>

            </div>

            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>

    

@endsection 