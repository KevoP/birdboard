<div class="card">
    <h3 class="font-normal text-xl mb-3 p-4 -ml-5 border-l-4 border-blue-light">
        <a class="no-underline text-black" href="{{ $project->path() }}">
            {{ $project->title }}
        </a>    
    </h3>

    <p class="text-grey">
        {{ str_limit($project->description, 120) }}
    </p>
</div>