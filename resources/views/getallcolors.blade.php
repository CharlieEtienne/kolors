@extends('layouts.app')

@section('css')
    <style>
    </style>
@endsection

@section('content')
<div class="container palettes-container">
    
    <div class="row mt-4 mb-4 title">
        <h2 class=""><a href="{{ url('/') }}" class="btn btn-sm btn-outline-secondary mr-2" style="line-height: 1em;"><i class="material-icons" style="transform: rotate(180deg);">subdirectory_arrow_right</i></a>  <span class="">Colors in code</span></h2>
        <ul class="tg-list">
            <li class="tg-list-item">
                <span class="text-muted mr-2 pull-left">More / Less details</span>
                <input type="checkbox" id="cb2" class="tgl tgl-ios">
                <label for="cb2" class="tgl-btn pull-left"></label>
            </li>
        </ul>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <textarea id="codemirror"></textarea>
        </div>
    </div>

    <div class="row palette">

    </div>
@endsection

@section('scripts')
    <script>

        $(document).on('change', '#cb2', function (e) {
            if ($('#cb2').prop('checked') == true) {
                $('.palette').addClass('detailed');
            }
            else {
                $('.palette').removeClass('detailed');
            }
        });
        Code = CodeMirror.fromTextArea(document.getElementById("codemirror"), {
            mode: "kolors",
            lineNumbers: true,
            matchBrackets: true,
            theme: 'material',
            scrollbarStyle: 'simple',
        });

        var demoCode = '';
        // demoCode += '<!-- Paste or write some code here to get all colors inside it! -->\n';
        // demoCode += '<style>\n';
        // demoCode += '   #k { color:#8B1C42 }\n';
        // demoCode += '   #o { color:#0A4A75 }\n';
        // demoCode += '   #l { color:#36D6DA }\n';
        // demoCode += '   #o { color:#F7B409 }\n';
        // demoCode += '   #r { color:#F03B0E }\n';
        // demoCode += '   #s { color:#0AD875 }\n';
        // demoCode += '</style>';
        demoCode += '<!-- Paste or write some code here to get all colors inside it! -->\n\n';
        demoCode += '<!-- FROM CSS  --> <style> #kolors { color:#8B1C42 } </style>\n\n';
        demoCode += '<!-- FROM JS   --> <script> $(\'#kolors\').css( \'color\', \'#0A4A75\' ); <\/script>\n\n';
        demoCode += '<!-- FROM HTML --> <span id="kolors" style="#36D6DA">kolors</span>\n\n';
        demoCode += '<!-- OR TEXT   --> kolors => #F7B409 (or maybe #F03B0E or #0AD875)';
        Code.setValue(demoCode);
        Code.focus();

        Code.on('change', function (e) {
            displayColors();
        });

        $(document).ready(function (e) {
            displayColors();
            hoverColor();
        });
        
        function displayColors() {
            
            var codeStr = Code.getValue();
            colorsInCode = getAllColors(codeStr);
            $('.palette').html('');

            colorsInCode.forEach(color => {
                var str = '';
                str += '<div class="col-lg-4 col-sm-6 col-12 color-item" id=""><div class="color-container flex-grow flexbox gap-items"><div class="color-background"><div class="color clipboard" ';
                str += 'data-clipboard-text="' + color.original + '" ';
                str += 'style="background-color:' + color.original + '" ';
                str += '><i class="material-icons">colorize</i></div></div><div class="color-details">';
                str += '<h6 class="color-name text-truncate">Color #' + color.index + '</h6>';
                str += '<span class="color-code original"><code>' + color.original + '</code></span>';
                str += '<div class="color-more-details">';
                str += '<span class="color-code orig"><em>ORIG: </em><code>' + color.original + '</code></span>';
                str += '<span class="color-code hex"><em>HEX: </em><code>' + color.hex + '</code></span>';
                str += '<span class="color-code rgb"><em>RGB: </em><code>' + color.rgb + '</code></span>';
                str += '<span class="color-code hsl"><em>HSL: </em><code>' + color.hsl + '</code></span>';
                str += '<span class="color-code name"><em>NAME: </em>';
                if(color.name) {
                str += '<code>' + color.name + '</code>';
                }
                else {
                    str += '<em>N/A</em>'
                }
                str += '</span>';
                str += '</div></div></div></div>';

                $('.palette').append(str);
            });
            hoverColor();
        }
        var clipboard = new ClipboardJS('.clipboard');
        
        clipboard.on('success', function(e) {
            toastr.options.toastClass = 'copy';
            toastr.success('Copied ' + e.text + ' to clipboard!');
        });

        function simpleView() {
            if ($('.palette').hasClass('simple-view')) {
                $('.color').each(function (e) {
                    var container = $(this).parents('.color-container');
                    var icon = $(this).find('.material-icons');
                    var name = $(container).find('.color-name');
                    var code = $(container).find('.color-code em, .color-code code');
                    var color = $(this).data('clipboard-text');
                    var cst = contrast(color);
                    
                    $(icon).css({
                        'opacity': 1,
                        'color': cst
                    });
                    
                    $(container)
                        .css('background-color', color);
                    
                    $(name).css('cssText', 'color:' + cst + ' !important;');
                    
                    $(code).css('cssText', 'color:' + cst + ' !important;');
                });
            } else {
                $('.color').each(function (e) {
                    var container = $(this).parents('.color-container');
                    var icon = $(this).find('.material-icons');
                    var name = $(container).find('.color-name');
                    var code = $(container).find('.color-code em, .color-code code');

                    $(icon).css({
                        'opacity': 0,
                        'color': ''
                    });

                    $(container)
                        .css('background-color', '')
                        .toggleClass('hover')
                        .tooltip('dispose');

                    $(name).css('cssText', '');
                    $(code).css('cssText', '');
                });
            }
        }

        function hoverColor() {
            $('.color').hover(function (e) {
            
                var container = $(this).parents('.color-container');
                var icon = $(this).find('.material-icons');
                var name = $(container).find('.color-name');
                var code = $(container).find('.color-code em, .color-code code');
                var color = $(this).data('clipboard-text');
                var cst = contrast(color);

                $(icon).css({
                    'opacity': 1,
                    'color': cst
                });
                
                $(container)
                    .css('background-color', color)
                    .toggleClass('hover')
                    .attr('data-original-title', 'Click to copy ' + color)
                    .tooltip('show');
                
                $(name).css('cssText', 'color:' + cst + ' !important;');
                
                $(code).css('cssText', 'color:' + cst + ' !important;');

            }, function (e) {

                var container = $(this).parents('.color-container');
                var icon = $(this).find('.material-icons');
                var name = $(container).find('.color-name');
                var code = $(container).find('.color-code em, .color-code code');

                $(icon).css({
                    'opacity': 0,
                    'color': ''
                });

                $(container)
                    .css('background-color', '')
                    .toggleClass('hover')
                    .tooltip('dispose');

                $(name).css('cssText', '');
                $(code).css('cssText', '');

            });
        }
    </script>
@endsection