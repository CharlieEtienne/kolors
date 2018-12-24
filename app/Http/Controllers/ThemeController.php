<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function switch_mode(Request $request)
    {
        if ($request->has('dark_mode')) {            
            if ($request->input('dark_mode') === 'false') {
                session()->put('dark_mode', 'dark');
                return response()->json([ 'dark_mode' => true ]);
            }
            else {
                session()->put('dark_mode', 'light');
                return response()->json([ 'dark_mode' => false ]);
            }
        }
    }
}
