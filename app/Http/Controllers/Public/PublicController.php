<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use App\Services\PartnerService;
use App\Services\TestimonialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    protected NewsService $news_service;

    protected TestimonialService $testimonial_service;

    protected PartnerService $partner_service;

    public function __construct(NewsService $news_service, TestimonialService $testimonial_service, PartnerService $partner_service)
    {
        $this->news_service = $news_service;
        $this->testimonial_service = $testimonial_service;
        $this->partner_service = $partner_service;
    }

    /**
     * Página inicial (/)
     */
    public function home()
    {
        $partners = $this->partner_service->getAll();
        $news = $this->news_service->getPaginated(5);
        $testimonials = $this->testimonial_service->getPaginated(2);

        return view('public.home', [
            'news' => $news,
            'testimonials' => $testimonials,
            'partners' => $partners,
        ]);
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
        $partners = $this->partner_service->getAll();

        return view('public.partners', [
            'partners' => $partners,
        ]);
    }

    /**
     * Página depoimentos (/depoimentos)
     */
    public function testimonials()
    {
        $testimonials = $this->testimonial_service->getPaginated(12);

        return view('public.testimonials', [
            'testimonials' => $testimonials,
        ]);
    }

    public function storeTestimonial(Request $request)
    {
        $validated = $request->validate([
            'nome' => 'required|string|max:100',
            'descricao' => 'required|string|max:500',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated = [
            'name' => $validated['nome'],
            'description' => $validated['descricao'],
        ];

        if ($request->hasFile('foto')) {
            $imagePath = $request->file('foto')->store('testimonials', 'public');
            $validated['image'] = $imagePath;
        }

        try {
            $this->testimonial_service->create($validated);

            return redirect()->back()->with('success', 'Depoimento enviado com sucesso! Ele será exibido no site assim que um administrador aprovar.');
        } catch (\Throwable $e) {
            Log::error('Failed to store testimonial', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao enviar depoimento.');
        }
    }

    /**
     * Página notícias (/noticias)
     */
    public function news()
    {
        $news = $this->news_service->getPaginated(12);

        return view('public.news', [
            'news' => $news,
        ]);
    }

    /**
     * Página notícias (/noticias/{id})
     */
    public function showNews(int $id)
    {
        try {
            $news = $this->news_service->getById($id);

            return view('public.show-news', [
                'news' => $news,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->route('public.news')->with('error', 'Notícia não encontrada.');
        } catch (\Throwable $e) {
            Log::error('Failed to load news', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('public.news')->with('error', 'Erro ao carregar notícia.');
        }
    }
}
