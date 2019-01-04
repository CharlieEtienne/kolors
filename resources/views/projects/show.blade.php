@extends('layouts.app')

@section('css')
    <style>
        
    </style>
@endsection

@section('content')
<div class="container palettes-container">
    <div class="row mt-4 mb-4 title">
       <h2 class="editable-content"><a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary mr-2" style="line-height: 1em;"><i class="material-icons" style="transform: rotate(180deg);">subdirectory_arrow_right</i></a> <span class="editable" data-id="{{ $project->id }}" data-type="p" data-action="update" data-elem="name">{{ $project->name }}</span></h2>
    </div>
    <div class="row mt-4 mb-4" id="palette-add">
        <button type="button" class="btn btn-add"><i class="fas fa-plus text-muted"></i>&nbsp;Add new palette</button>
    </div>
    @foreach ($project->palettes as $palette)
        <div id="palette-{{ $palette->id }}">
            <div class="row mt-4 border-bottom border-faded cursor-pointer" data-toggle="collapse" data-target="#palette_item-{{ $palette->id }}" aria-expanded="true" aria-controls="palette_item-{{ $palette->id }}">
                <div class="col-sm-5 col-md-auto col-5 palette-heading">
                    <h3 class="text-truncate editable-content"><i class="fas fa-palette title-icon"></i><span class="editable" data-id="{{ $palette->id }}" data-type="pl" data-action="update" data-elem="name">{{$palette->name}}</span></h3>
                </div>
                <div class="col-sm-5 col-md-auto col-5 palette-mini-container">
                    <div class="palette-mini" id="palette-mini-{{ $palette->id }}">
                        @foreach ($palette->colors->take(8) as $color)<span style="background-color:{{ $color->code }}"></span>@endforeach
                    </div>
                </div>
                <div class="col-auto ml-auto">
                    <button class="btn btn-sm btn-outline-secondary btn-expand pull-right" type="button" data-toggle="collapse" data-target="#palette_item-{{ $palette->id }}" aria-expanded="true" aria-controls="palette_item-{{ $palette->id }}"></button>
                </div>
            </div>
            <div class="row palette collapse show" id="palette_item-{{ $palette->id }}">
                    
                @foreach ($palette->colors as $color)    
                    <div class="col-lg-4 col-sm-6 col-12 color-item" id="color-{{ $color->id }}">
                        <div class="color-container flex-grow flexbox gap-items">
                            <div class="color clipboard" data-clipboard-text="{{ $color->code }}" style="background-color:{{ $color->code }}">
                                <i class="material-icons">colorize</i>
                            </div>
                            <div class="color-details">
                                <h6 class="color-name text-truncate">{{ $color->name }}</h6>
                                <span class="color-code"><code>{{ $color->code }}</code></span>
                            </div>
                            <div><button type="button" class="btn btn-link btn-edit-color" v-on:click="state.ColorEdit=true"><i class="fas fa-pen"></i></button></div>
                        </div>
                        <chrome-picker v-if="state.ColorEdit" :value="'{{ $color->code }}'"></chrome-picker>
                    </div>
                @endforeach
                <div class="col-lg-4 col-sm-6 col-12 " id="color-add">
                    <button type="button" class="btn btn-block btn-add mt-0" style="margin-bottom: 15px; height:78px;" :style="{'background-color': bgc}" data-belongs-to="{{ $palette->id }}"><i class="fas fa-plus text-muted"></i>&nbsp;Add new color</button>
                    <chrome-picker :value="colors" @input="updateValue"></chrome-picker>
                </div>

            </div>
        </div>
    @endforeach


</div>
@endsection

@section('scripts')
    <script>

        $('.color').hover(function (e) {
            
            var container = $(this).parent('.color-container');
            var icon = $(this).find('.material-icons');
            var name = $(container).find('.color-name');
            var code = $(container).find('.color-code code');
            var color = $(this).data('clipboard-text');
            var cst = contrast(color);

            $(icon).css({
                'opacity': 1,
                'color': cst
            });
            
            $(container)
                .css('background-color', color)
                .attr('data-original-title', 'Click to copy ' + color)
                .tooltip('show');
            
            $(name).css('cssText', 'color:' + cst + ' !important;');
            
            $(code).css('cssText', 'color:' + cst + ' !important;');

        }, function (e) {

            var container = $(this).parent('.color-container');
            var icon = $(this).find('.material-icons');
            var name = $(container).find('.color-name');
            var code = $(container).find('.color-code code');

            $(icon).css({
                'opacity': 0,
                'color': ''
            });

            $(container)
                .css('background-color', '')
                .tooltip('dispose');

            $(name).css('cssText', '');
            $(code).css('cssText', '');

        });
        
        var clipboard = new ClipboardJS('.clipboard');
        
        clipboard.on('success', function(e) {
            toastr.options.toastClass = 'copy';
            toastr.success('Copied ' + e.text + ' to clipboard!');
        });

    </script>

    <script>

        $( ".palette .color-item" ).draggable({
            cancel: "a.ui-icon",
            revert: "invalid", 
            containment: "document",
            helper: "clone",
            cursor: "move",
            zIndex: 9999
        });
        $( ".palette" ).droppable({
            accept: ".palette .color-item",
            classes: {
                "ui-droppable-hover": "ui-state-highlight"
            },
            drop: function( event, ui ) {
                
                $item = $(ui.draggable);
                $target = $(event.target);
                var Color = $item.attr('id').split('-')[1];
                var Palette = $target.attr('id').split('-')[1];

                $item.appendTo( $target );
                updateColorPalette(Color, Palette);
            }
        });

        

        function updateColorPalette(Color, Palette) {
            toastr.options.toastClass = '';
            $.ajax({
                url:"{{ url('/updateColorPalette') }}",
                type:'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data:{'color': Color, 'palette': Palette},
                success:function(data){
                    toastr.success(data.success);
                    $('.palette-mini').each(function (e) {
                        var elemID = $(this).attr('id');
                        $(this).load(document.URL + ' #' + elemID, function() {
                            $(this).children(':first').unwrap();
                        });
                    });
                },
                error: function (data) {
                    console.log(data);
                }
            })
        }

        // Add new palette
        $(document).on('click','#palette-add button', function (e) {
            $('.palettes-container').append('<div class="row mt-4 border-bottom border-faded cursor-pointer" id="new-palette"><div class="col-sm-5 col-md-auto col-5 palette-heading"><h3 class="text-truncate editable-content"><i class="fas fa-palette title-icon"></i><span class="editable" data-type="pl" data-action="create" data-belongs-to="'+{{$project->id}}+'" data-elem="name">My palette</span></h3></div></div>');
            new StaticEdit.Editor({
                saveButton: false,
                selector: '.editable',
                bgSelector: '.bg-editable',
            });
            $('#new-palette .palette-heading .editable').trigger('click');
        });

        // Add new color
        $(document).on('click','#color-add button', function (e) {
            var PaletteId = e.target.dataset.belongsTo;
            $('.palettes-container').append('<div class="row mt-4 border-bottom border-faded cursor-pointer" id="new-color"><div class="col-sm-5 col-md-auto col-5 palette-heading"><h3 class="text-truncate editable-content"><i class="fas fa-palette title-icon"></i><span class="editable" data-type="pl" data-action="create" data-belongs-to="'+ PaletteId +'" data-elem="name">My palette</span></h3></div></div>');
            // new StaticEdit.Editor({
            //     saveButton: false,
            //     selector: '.editable',
            //     bgSelector: '.bg-editable',
            // });
            // $('#new-color .palette-heading .editable').trigger('click');
        });
    </script>
@endsection