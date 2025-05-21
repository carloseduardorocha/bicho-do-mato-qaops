<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;

class AdocaoController extends Controller
{
    public function index(Request $request)
    {
        $query = Pet::where('status', 'Disponível');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        $pets = $query->latest()->get();

        return view('public.adocao', compact('pets'));
    }
}