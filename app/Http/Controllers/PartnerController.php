<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Partner;

class PartnerController extends Controller
{
    public function index()
    {
        $parceiros = Partner::all();
        return view('parceiros', compact('parceiros'));
    }

    public function create()
    {
        return view('admin.parceiros.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'link' => 'nullable|url',
            'logo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('parceiros', 'public');
        }

        Partner::create($data);
        return redirect()->route('admin.parceiros.index')->with('success', 'Parceiro cadastrado com sucesso.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();
        return redirect()->route('admin.parceiros.index')->with('success', 'Parceiro removido.');
    }
}