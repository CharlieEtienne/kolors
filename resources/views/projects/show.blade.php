@extends('layouts.app')

@section('css')
    <style>
        .toast-success.copy {
            background-color: #000;
        }
    </style>
@endsection

@section('content')
<div class="container">
    
    @foreach ($project->palettes as $palette)
        <div class="row mt-4">
            <div class="col-sm-auto col-6 palette-heading">
                <h3 class="text-truncate"><i class="fas fa-palette title-icon"></i>{{$palette->name}}</h3>
            </div>
            <div class="col-sm-auto col-6 palette-mini-container">
                <div class="palette-mini" id="palette-mini-{{ $palette->id }}">
                    @foreach ($palette->colors->take(8) as $color)<span style="background-color:{{ $color->code }}"></span>@endforeach
                </div>
            </div>
        </div>
        <div class="row palette" id="palette-{{ $palette->id }}">
                
            @foreach ($palette->colors as $color)    
                <div class="col-lg-4 col-sm-6 col-12 color-item" id="color-{{ $color->id }}">
                    <div class="color-container flex-grow flexbox gap-items">
                        <div class="color clipboard" data-clipboard-text="{{ $color->code }}" style="background-color:{{ $color->code }}"><i class="material-icons">colorize</i>
                        </div>
                        <div class="color-details text-truncate">
                            <h6 class="color-name">{{ $color->name }}</h6>
                            <span class="color-code"><code>{{ $color->code }}</code></span>
                        </div>
                    </div>
                </div>
            @endforeach

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
                .css('background-color', '#fff')
                .tooltip('dispose');

            $(name).css('cssText', '');
            $(code).css('cssText', '');

        });
        
        var clipboard = new ClipboardJS('.clipboard');
        
        clipboard.on('success', function(e) {

            toastr.options = {
                "positionClass": "toast-top-center",
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "600",
                "timeOut": "1000",
                "toastClass": 'copy',
            };

            toastr.success('Copied ' + e.text + ' to clipboard!');
        });
        
        $('.color-container').each(function (e) {
            
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
            toastr.options = {
                "positionClass": "toast-top-center",
                "preventDuplicates": true,
                "showDuration": "300",
                "hideDuration": "600",
                "timeOut": "1000",
                "toastClass": '',
            };
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
    </script>
@endsection