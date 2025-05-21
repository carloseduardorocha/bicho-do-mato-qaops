<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pet;

class PetController extends Controller
{
    public function index()
    {
        $pets = Pet::latest()->get();
        return view('admin.pets.index', compact('pets'));
    }

    public function create()
    {
        return view('admin.pets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:100',
            'type'       => 'required|in:Cachorro,Gato',
            'gender'     => 'required|in:Macho,Fêmea',
            'age_group'  => 'required|in:Filhote,Adulto',
            'size'       => 'required|in:Pequeno,Médio,Grande',
            'tags'       => 'nullable|string',
            'image'      => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('pets', 'public');
        }

        $data['tags'] = json_encode(array_map('trim', explode(',', $data['tags'] ?? '')));
        $data['status'] = 'Disponível';

        Pet::create($data);

        return redirect()->route('admin.pets.index')->with('success', 'Pet cadastrado com sucesso.');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->image_path) {
            Storage::disk('public')->delete($pet->image_path);
        }

        $pet->delete();
        return redirect()->route('admin.pets.index')->with('success', 'Pet removido.');
    }

    public function toggleStatus(Pet $pet)
    {
        $pet->status = $pet->status === 'Adotado' ? 'Disponível' : 'Adotado';
        $pet->save();

        return redirect()->route('admin.pets.index')->with('success', 'Status atualizado.');
    }
}