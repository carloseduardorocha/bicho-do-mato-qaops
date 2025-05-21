@extends('layouts.app')

@section('title', 'Admin - Depoimentos')

@section('content')
<section class="max-w-5xl mx-auto py-8 px-4">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Gerenciar Depoimentos</h2>
    <a href="{{ route('admin.testimonials.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Depoimento</a>
  </div>

  @forelse ($depoimentos as $depoimento)
    <div class="bg-white p-4 mb-4 rounded shadow">
      <div class="flex items-center gap-4">
        @if($depoimento->image_path)
          <img src="{{ asset('storage/' . $depoimento->image_path) }}" class="h-16 w-16 object-cover rounded-full" alt="{{ $depoimento->name }}">
        @endif
        <div>
          <h3 class="text-lg font-semibold">{{ $depoimento->name }}</h3>
          <p class="text-sm text-gray-600">{{ $depoimento->message }}</p>
        </div>
      </div>
      <form action="{{ route('admin.testimonials.destroy', $depoimento) }}" method="POST" class="mt-2">
        @csrf @method('DELETE')
        <button class="text-sm text-red-600 hover:underline">Excluir</button>
      </form>
    </div>
  @empty
    <p class="text-center text-gray-500">Nenhum depoimento cadastrado.</p>
  @endforelse
</section>
@endsection