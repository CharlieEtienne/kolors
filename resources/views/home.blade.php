@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-12 text-center navbar-brand m-0" style="font-size: 4rem !important; letter-spacing: -0.05rem;">
            <span id="logo-k">k</span><span id="logo-o">o</span><span id="logo-l">l</span><span id="logo-o2">o</span><span id="logo-r">r</span><span id="logo-s">s</span>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-6 text-center">
            <h2 class="text-pale-less">A free Colors and Typos Library for web designers and developers</h2>
        </div>
    </div>
    <div class="row justify-content-center pt-4">
        <div class="col-12 text-center">
            <a class="btn btn-lg btn-purple" href="{{ url('/register') }}">Get Started<i class="material-icons ml-2">arrow_forward</i></a>
        </div>
    </div>
    <div class="row justify-content-center pt-5 mt-2">
        <div class="col-12 text-center">
            <h5 class="text-pale-less">or check kolorsInCode, a free tool to extract colors from source code</h5>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 text-center navbar-brand m-0" style="font-size: 2.7rem !important; letter-spacing: -0.05rem;">
                <a class="no-link" href="{{ url('/in/code') }}">kolorsInCode()</a>
        </div>
    </div>
</div>
@endsection
