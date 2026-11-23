<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TestimonialService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TestimonialController extends Controller
{
    protected TestimonialService $testimonial_service;

    public function __construct(TestimonialService $testimonial_service)
    {
        $this->testimonial_service = $testimonial_service;
    }

    /**
     * List approved testimonials.
     */
    public function index(Request $request)
    {
        try {
            $per_page = $request->integer('per_page', 15);
            $testimonials = $this->testimonial_service->getPaginated($per_page);

            return view('admin.testimonials.index', compact('testimonials'));
        } catch (\Throwable $e) {
            Log::error('TestimonialController@index failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao carregar a lista de depoimentos.');
        }
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store a new testimonial.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Upload de imagem
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('testimonials', 'public');
                $validated['image'] = $imagePath;
            }

            $this->testimonial_service->create($validated);

            return redirect()->route('admin.testimonials.index')->with('success', 'Depoimento criado com sucesso!');

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('TestimonialController@store failed', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao criar depoimento.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(int $id)
    {
        try {
            $testimonial = $this->testimonial_service->getById($id);

            return view('admin.testimonials.edit', compact('testimonial'));

        } catch (\Throwable $e) {
            Log::error('TestimonialController@edit failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('admin.testimonials.index')->with('error', 'Depoimento não encontrado.');
        }
    }

    /**
     * Update a testimonial by ID.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'required|string|max:500',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Upload de imagem
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('testimonials', 'public');
                $validated['image'] = $imagePath;
            }

            $this->testimonial_service->update($id, $validated);

            return redirect()->route('admin.testimonials.index')->with('success', 'Depoimento atualizado com sucesso!');

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            Log::error('TestimonialController@update failed', [
                'id' => $id,
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar depoimento.');
        }
    }

    /**
     * Delete a testimonial by ID (soft delete).
     */
    public function destroy(int $id)
    {
        try {
            $this->testimonial_service->delete($id);

            return redirect()->route('admin.testimonials.index')->with('success', 'Depoimento removido com sucesso!');

        } catch (\Throwable $e) {
            Log::error('TestimonialController@destroy failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao remover depoimento.');
        }
    }

    /**
     * Show moderation page (pending testimonials).
     */
    public function moderate(Request $request)
    {
        try {
            $per_page = $request->integer('per_page', 15);
            $pending = $this->testimonial_service->getPending($per_page);

            return view('admin.testimonials.moderate', compact('pending'));

        } catch (\Throwable $e) {
            Log::error('TestimonialController@moderate failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao carregar depoimentos pendentes.');
        }
    }

    /**
     * Approve testimonial.
     */
    public function approve(int $id)
    {
        try {
            $this->testimonial_service->approve($id);

            return redirect()->route('admin.testimonials.moderate')->with('success', 'Depoimento aprovado com sucesso!');

        } catch (\Throwable $e) {
            Log::error('TestimonialController@approve failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao aprovar depoimento.');
        }
    }

    /**
     * Reject testimonial.
     */
    public function reject(int $id)
    {
        try {
            $this->testimonial_service->reject($id);

            return redirect()->route('admin.testimonials.moderate')->with('success', 'Depoimento rejeitado com sucesso!');

        } catch (\Throwable $e) {
            Log::error('TestimonialController@reject failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao rejeitar depoimento.');
        }
    }
}
