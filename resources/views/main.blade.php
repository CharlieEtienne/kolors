@extends('layouts.app')

@section('content')

@include('modals.project_delete')

<div class="container">
    <div class="row">
   
        @foreach ($projects as $project)
            <div class="col-lg-3 col-md-4 col-sm-6 col-12 project" id="project-{{ $project->id }}">
                <div class="card project-container">
                    <a class="hover-decoration-none" href="{{ url('/p/' . $project->id) }}">
                        <div class="card-img-top project-preview">
                            <div class="palette-mini">
                                @foreach ($project->colors->shuffle()->take(24) as $color)<span class="col-2" style="background-color:{{ $color->code }}"></span>@endforeach
                            </div>
                            <div class="card-img-overlay"><i class="far fa-eye"></i></div>
                        </div>
                    </a>
                    <button type="button" class="project-delete" data-id="{{ $project->id }}" data-toggle="modal" data-target="#ProjectDeleteModal"><i class="fas fa-trash"></i></button>
                    <div class="card-body p-3">
                        <h4 class="card-title project-title mb-2 editable-content"><span class="editable" data-id="{{ $project->id }}" data-type="p" data-action="update" data-elem="name">{{ $project->name }}</span></h4>
                        <div class="project-details">
                            <i class="material-icons">palette</i><small class="project-description m-0 mr-3 text-muted">{{ $project->palettes->count() }}</small>
                            <i class="material-icons">colorize</i><small class="project-description m-0 text-muted">{{ $project->colors->count() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 project" id="project-add">
            <button type="button" class="btn btn-block btn-add"><i class="fas fa-plus text-muted"></i>&nbsp;Add new project</button>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(document).on('show.bs.modal', '#ProjectDeleteModal', function (event) {
            var button = $(document).find(event.relatedTarget);
            var project_id = button.data('id');
            // console.log(project_id);
            $(document).find('#ProjectDeleteModal #ConfirmDelete').attr('data-id', project_id);
        });

        $(document).on('click', '#ProjectDeleteModal #ConfirmDelete', function (event) {
            var project_id = event.delegateTarget.activeElement.dataset.id;
            $.ajax({
                url:"{{ url('/p')  }}" + "/" + project_id,
                type: "delete",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function (data) {
                    $('#ProjectDeleteModal').modal('hide');
                    var $ProjectToDelete = $('div').find('#project-' + data.id);
                    
                    $ProjectToDelete.fadeOut('slow', function () {
                            $(this).load(document.URL +  ' #project-' + data.id, function() {
                                $(this).children(':first').unwrap();
                        });
                    });
                    toastr.options.toastClass = '';
                    toastr.success(data.success);
                },
                error: function (data) {
                    console.log(data);
                    toastr.error('Whoops! An error occured...');
                }
            });
        });

        $(document).on('click','#project-add button', function (e) {
            $('#project-add').before('<div class="col-lg-3 col-md-4 col-sm-6 col-12 project" id="new-project"><div class="card project-container"><div class="card-img-top project-preview"><div class="palette-mini"></div></div><div class="card-body p-3"><h4 class="card-title project-title mb-2 editable-content"><span class="editable" data-id="" data-type="p" data-action="create" data-elem="name">My Project</span></h4><div class="project-details"><i class="material-icons">palette</i><small class="project-description m-0 mr-3 text-muted">0</small><i class="material-icons">colorize</i><small class="project-description m-0 text-muted">0</small></div></div></div</div>');
            new StaticEdit.Editor({
                saveButton: false,
                selector: '.editable',
                bgSelector: '.bg-editable',
            });
            $('#new-project .project-title .editable').trigger('click');
        });
    </script>
@endsection