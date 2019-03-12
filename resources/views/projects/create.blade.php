@extends('layouts.app')

@section('content')
    <h1 class="title">Create a Project</h1>
    
        <form action="/projects" method="post">
            @csrf

            <div class="field">
                
                <label for="" class="label">
                    Title
                </label>

                <div class="control">
                    <input type="text" class="text" name="title" placeholder="title">
                </div>

            </div>

            <div class="field">
                <label for="" class="label">
                    Description
                </label>
                <div class="control">
                    <textarea name="description" id="" cols="30" rows="10" class="textarea"></textarea>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <button class="button is-link">Create Project</button>
                    <a href="/projects" class="button is-link">Back</a>
                </div>
            </div>

        </form>
@endsection