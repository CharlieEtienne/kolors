<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->check()) {
            // $projects = auth()->user()->projects()->with('colors', 'typos')->get();
            $projects = Project::with('colors', 'typos')->get();
            return view('main', compact('projects'));
        }
        else {
            return view('home');
        }
    }
}
