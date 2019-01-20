<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-68856936-2"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-68856936-2');
    </script>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'kolors') }}</title>

    <meta name="description" content="A free Colors and Typos Library for web designers and developers">
	<meta name="author" content="Charlie ETIENNE">
	<meta name="google-site-verification" content="">
	<link rel="shortcut icon" href="{{ url('/') }}/favicon.png">
	<link rel="image_src" type="image/jpeg" href="{{ url('/') }}/kolors-logo.png">
	
<!--Open Graph Protocol-->
	<meta property="og:image" content="{{ url('/') }}/kolors-logo.png">
	<meta property="og:image:type" content="image/jpeg">
	<meta property="og:site_name" content="kolors">
	<meta property="og:title" content="kolors">
	<meta property="og:type" content="website">
	<meta property="og:url" content="https://kolors.app/">
	<meta property="og:description" content="A free Colors and Typos Library for web designers and developers">

    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @yield('css')
</head>
<body class="@if((isset($dark_mode) OR session('dark_mode') == 'dark') AND session('dark_mode') != 'light') dark @endif">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <span id="logo-k">k</span><span id="logo-o">o</span><span id="logo-l">l</span><span id="logo-o2">o</span><span id="logo-r">r</span><span id="logo-s">s</span>
                </a>
                <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">Home</a>
                        </li>
                        <!-- Colors in code -->
                        <li class="nav-item">
                            <a href="{{ url('in/code') }}" class="nav-link">Colors in Code</a>
                        </li>
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
                <ul class="navbar-nav toolbar-tools">
                    <!-- Switch to dark/light mode -->
                    <li class="nav-item">    
                        <a href="#" id="switch_mode" class="switch-dark-light nav-link text-pale" data-tooltip="tooltip" title="Dark/Light Mode"><i class="dark-mode-icon far fa-moon"></i><i class="light-mode-icon far fa-sun"></i></a>
                    </li>
                    <!-- GitHub link -->
                    <li class="nav-item">
                        <a href="https://github.com/CharlieEtienne/kolors" class="nav-link text-pale" data-tooltip="tooltip" title="Code"><i class="fab fa-github"></i></a>
                    </li>
                </ul>
            </div>
            
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="m-auto"><a href="https://github.com/CharlieEtienne/kolors"><i class="fab fa-github pt-3 pb-3 text-pale" style="font-size: 2em;"></i></a></div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        toastr.options = {
            "positionClass": "toast-top-center",
            "preventDuplicates": true,
            "showDuration": "300",
            "hideDuration": "600",
            "timeOut": "1000",
            "toastClass": '',
        };

        (function () {
            new StaticEdit.Editor({
                saveButton: false, // Whether to show the save button or not
                selector: '.editable', // The selector to use for all the elements
                bgSelector: '.bg-editable', // The selector to use for all background image edition
            })
        })();

        // An editable element was clicked
        window.addEventListener('static_edit.editing', function (e) {
            document.addEventListener('keydown', function (e) {
                if (e.key == 'Enter') {
                    // ???
                }
            });
        });

        // An editable element was changed
        window.addEventListener('static_edit.edited', function (e) {

            var Elem        = $(e.detail.elem).data('elem');
            var Type        = $(e.detail.elem).data('type');
            var Id          = $(e.detail.elem).data('id');
            var Action      = $(e.detail.elem).data('action');
            var OldValue    = e.detail.oldValue;
            var NewValue    = e.detail.newValue;
            var BelongsTo   = $(e.detail.elem).data('belongs-to');
            var DisplayType = 'project';

            if (NewValue == '' || $.isEmptyObject(NewValue) ) {
                switch (Type) {
                    case 'p'  : DisplayType = 'project'; break;
                    case 'pl' : DisplayType = 'palette'; break;
                }
                $(e.detail.elem).html('My ' + DisplayType);
                NewValue = 'My ' + DisplayType;
            }

            if (Action == 'update') {

                var AjaxUrl     = "{{ url('/')  }}" + "/" + Type + "/" + Id;
                var AjaxType    = 'put';
                var AjaxData    = {'Elem': Elem, 'Type': Type, 'Id': Id, 'NewValue': NewValue};

            } else if (Action == 'create') {

                if (NewValue == null && OldValue != '') {
                    NewValue = OldValue;
                }
                var AjaxUrl     = "{{ url('/')  }}" + "/" + Type;
                var AjaxType    = 'post';
                var AjaxData    = {'Elem': Elem, 'Type': Type, 'NewValue': NewValue, 'BelongsTo': BelongsTo};
                
            }

            if (OldValue != NewValue || Action == 'create') {
                $.ajax({
                    url: AjaxUrl,
                    type: AjaxType,
                    data: AjaxData,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    datatype: "json",
                    success: function (data) {
                        toastr.options.toastClass = '';
                        toastr.success(data.success);
                        if (data.action == 'create') {
                            $('#new-' + data.type).load(document.URL +  ' #' + data.type + '-' + data.id, function() {
                                $(this).children(':first').unwrap();
                            });
                        }
                    },
                    error: function (data) {
                        toastr.error('Whoops! An error occured...');
                    }
                });
            }
        });

        window.addEventListener('static_edit.saving', function (e) {
            // The "save" button was clicked
            // e.detail.changed: contains a list of the elements that have been changed
            console.log(e.detail.changed);
        });

        $('#switch_mode').click(function (e) {
            var dark_mode = false;
            if ($('body').hasClass('dark')) {
                dark_mode = true;
            }
            // console.log(dark_mode);
            $.ajax({
                type: "POST",
                url:"/switch_mode",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {'dark_mode': dark_mode},
                success: function (data) {
                    // console.log(data);
                    $('body').toggleClass('dark');
                },
                error: function(data){
                    console.log(data);
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
