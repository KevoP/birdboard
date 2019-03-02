<!DOCTYPE html>
<html>
<head>
    <title>Projects</title>
</head>
<body>

    <div class="wrap">
        <h1 class="title">Projects</h1>

        <ul class="projects">
            @forelse($projects as $project)
                
                <li>
                    <a href="{{ $project->path() }}">
                        {{ $project->title }}
                    </a>
                </li>
                    
            @empty

                <p>No projects found</p>
            
            @endforelse
        </ul>
    </div>

</body>
</html>