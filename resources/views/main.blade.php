@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
   
        @foreach ($projects as $project)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card project-container">
                    <a class="hover-decoration-none" href="{{ url('/p/' . $project->id) }}">
                        <div class="card-img-top project-preview">
                            <div class="palette-mini">
                                @foreach ($project->colors->shuffle()->take(24) as $color)<span class="col-2" style="background-color:{{ $color->code }}"></span>@endforeach
                            </div>
                        </div>
                    </a>
                    <div class="card-body p-3">
                        <a class="hover-decoration-none" href="{{ url('/p/' . $project->id) }}">
                            <h4 class="card-title project-title mb-2">{{ $project->name }}</h4>
                        </a>
                        <div class="project-details flex-grow flexbox gap-items">
                            <small class="project-description m-0 text-muted">{{ $project->palettes->count() }} palettes</small>
                            <small class="project-description m-0 text-muted">{{ $project->colors->count() }} colors</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</div>
@endsection
