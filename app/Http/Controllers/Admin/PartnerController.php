<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\PartnerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PartnerController extends Controller
{
    protected PartnerService $partner_service;

    public function __construct(PartnerService $partner_service)
    {
        $this->partner_service = $partner_service;
    }

    /**
     * List all partners.
     */
    public function index(Request $request)
    {
        try {
            $per_page = $request->integer('per_page', 15);
            $partners = $this->partner_service->getPaginated($per_page);

            return view('admin.partners.index', compact('partners'));
        } catch (\Throwable $e) {
            Log::error('PartnerController@index failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao carregar a lista de parceiros.');
        }
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a new partner.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'link' => 'nullable|url|max:255',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('partners', 'public');
                $validated['image'] = $imagePath;
            }

            $this->partner_service->create($validated);

            return redirect()->route('admin.partners.index')->with('success', 'Parceiro criado com sucesso!');

        } catch (\Throwable $e) {
            Log::error('PartnerController@store failed', [
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao criar parceiro.');
        }
    }

    /**
     * Show edit form.
     */
    public function edit(int $id)
    {
        try {
            $partner = $this->partner_service->getById($id);

            return view('admin.partners.edit', compact('partner'));

        } catch (\Throwable $e) {
            Log::error('PartnerController@edit failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('admin.partners.index')->with('error', 'Parceiro não encontrado.');
        }
    }

    /**
     * Update a partner by ID.
     */
    public function update(Request $request, int $id)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'link' => 'nullable|url|max:255',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('partners', 'public');
                $validated['image'] = $imagePath;
            }

            $this->partner_service->update($id, $validated);

            return redirect()->route('admin.partners.index')->with('success', 'Parceiro atualizado com sucesso!');

        } catch (\Throwable $e) {
            Log::error('PartnerController@update failed', [
                'id' => $id,
                'data' => $request->all(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->withInput()->with('error', 'Erro ao atualizar parceiro.');
        }
    }

    /**
     * Delete a partner by ID (soft delete).
     */
    public function destroy(int $id)
    {
        try {
            $this->partner_service->delete($id);

            return redirect()->route('admin.partners.index')->with('success', 'Parceiro removido com sucesso!');

        } catch (\Throwable $e) {
            Log::error('PartnerController@destroy failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Erro ao remover parceiro.');
        }
    }
}
