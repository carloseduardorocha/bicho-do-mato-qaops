<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Partner;
use App\Models\Testimonial;

class DashboardController extends Controller
{
    public function index()
    {
        $partnersCount = Partner::count();
        $newsCount = News::count();
        $testimonialsCount = Testimonial::count();

        return view('admin.dashboard', compact(
            'partnersCount',
            'newsCount',
            'testimonialsCount'
        ));
    }
}
