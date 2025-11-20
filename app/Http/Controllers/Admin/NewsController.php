<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NewsController extends Controller
{
    protected NewsService $news_service;

    public function __construct(NewsService $news_service)
    {
        $this->news_service = $news_service;
    }

    /**
     * List all news.
     */
    public function index(Request $request)
    {
        try {
            $per_page = $request->integer('per_page', 15);
            $news = $this->news_service->getPaginated($per_page);

            return view('admin.news.index', compact('news'));
        } catch (\Throwable $e) {
            Log::error('NewsController@index failed', [
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Erro ao carregar a lista de notícias.');
        }
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a new news.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'required|string|max:5000',
                'images'      => 'nullable|array',
                'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Upload múltiplo de imagens
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('news', 'public');
                    $imagePaths[] = $path;
                }
            }

            $validated['images']    = !empty($imagePaths) ? json_encode($imagePaths) : null;
            $validated['author_id'] = auth()->id();

            $this->news_service->create($validated);

            return redirect()->route('admin.news.index')->with('success', 'Notícia criada com sucesso!');

        } catch (\Throwable $e) {
            Log::error('NewsController@store failed', [
                'data'  => $request->all(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao criar notícia.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(int $id)
    {
        try {
            $news = $this->news_service->getById($id);

            return view('admin.news.edit', compact('news'));

        } catch (\Throwable $e) {
            Log::error('NewsController@edit failed', [
                'id'    => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->route('admin.news.index')->with('error', 'Notícia não encontrada.');
        }
    }

    /**
     * Update a news by ID.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'required|string|max:5000',
                'images'      => 'nullable|array',
                'images.*'    => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Upload de novas imagens
            $newImagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('news', 'public');
                    $newImagePaths[] = $path;
                }

                // Merge com imagens antigas se existirem
                $news = $this->news_service->getById($id);
                $oldImages = !empty($news['images']) ? json_decode($news['images'], true) : [];
                
                // Combinar imagens antigas com novas
                $allImages = array_merge($oldImages, $newImagePaths);
                $validated['images'] = json_encode($allImages);
            }

            $this->news_service->update($id, $validated);

            return redirect()->route('admin.news.index')->with('success', 'Notícia atualizada com sucesso!');

        } catch (\Throwable $e) {
            Log::error('NewsController@update failed', [
                'id'    => $id,
                'data'  => $request->all(),
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar notícia.');
        }
    }

    /**
     * Delete a news by ID (soft delete).
     */
    public function destroy(int $id)
    {
        try {
            $this->news_service->delete($id);

            return redirect()->route('admin.news.index')->with('success', 'Notícia removida com sucesso!');

        } catch (\Throwable $e) {
            Log::error('NewsController@destroy failed', [
                'id'    => $id,
                'error' => $e->getMessage()
            ]);

            return redirect()->back()->with('error', 'Erro ao remover notícia.');
        }
    }

    /**
     * Delete single image from news.
     */
    public function deleteImage(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'image_path' => 'required|string',
            ]);

            $this->news_service->deleteImageFromNews($id, $validated['image_path']);

            return response()->json([
                'success' => true,
                'message' => 'Imagem removida com sucesso!'
            ]);

        } catch (\Throwable $e) {
            Log::error('NewsController@deleteImage failed', [
                'id'    => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erro ao remover imagem.'
            ], 500);
        }
    }
}