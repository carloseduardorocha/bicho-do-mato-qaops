<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    /**
     * Página inicial (/)
     */
    public function home()
    {
        return view('public.home');
    }

    /**
     * Página de ajuda (/ajuda)
     */
    public function help()
    {
        return view('public.help');
    }

    /**
     * Página institucional (/institucional)
     */
    public function about()
    {
        return view('public.about');
    }

    /**
     * Página parceiros (/parceiros)
     */
    public function partners()
    {
        return view('public.partners');
    }

    /**
     * Página depoimentos (/depoimentos)
     */
    public function testimonials()
    {
        return view('public.testimonials');
    }

    /**
     * Página notícias (/noticias)
     */
    public function news()
    {
        return view('public.news');
    }

    /**
     * Página notícias (/noticias)
     */
    public function showNews()
    {
        return view('public.show-news');
    }
}
