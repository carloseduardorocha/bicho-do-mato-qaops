<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function index()
    {
        $news = \App\Models\News::latest()->take(3)->get();
        $testimonials = \App\Models\Testimonial::latest()->get();

        return view('home', compact('news', 'testimonials'));
    }
}