<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $depoimentos = Testimonial::latest()->get();
        return view('admin.testimonials.index', compact('depoimentos'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'message' => 'required|string|max:1000',
            'image'   => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);
        return redirect()->route('admin.testimonials.index')->with('success', 'Depoimento cadastrado com sucesso.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image_path) {
            Storage::disk('public')->delete($testimonial->image_path);
        }

        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Depoimento removido.');
    }
}