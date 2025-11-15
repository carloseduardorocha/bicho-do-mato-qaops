<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
    {
        $noticias = News::get();
        dd($noticias);
        return view('admin.news.index', compact('noticias'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'author'      => 'required|string|max:100',
            'description' => 'required|string|max:255',
            'image'       => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('news', 'public');
        }

        News::create($data);
        return redirect()->route('admin.news.index')->with('success', 'Notícia cadastrada com sucesso.');
    }

    public function destroy(News $news)
    {
        if ($news->image_path) {
            Storage::disk('public')->delete($news->image_path);
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'Notícia removida.');
    }

    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }
}