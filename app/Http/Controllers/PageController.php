<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function help()
    {
        return view('como_ajudar');
    }

    public function about()
    {
        return view('institucional');
    }
    
}