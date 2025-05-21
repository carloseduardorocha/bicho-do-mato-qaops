@extends('layouts.app')

@section('title', 'Admin - Pets para Adoção')

@section('content')
<section class="max-w-6xl mx-auto py-8 px-4">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Gerenciar Pets para Adoção</h2>
    <a href="{{ route('admin.pets.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Novo Pet</a>
  </div>

  <div class="grid md:grid-cols-2 gap-6">
    @forelse ($pets as $pet)
      <div class="bg-white p-4 rounded shadow">
        @if($pet->image_path)
          <img src="{{ asset('storage/' . $pet->image_path) }}" alt="{{ $pet->name }}" class="w-full h-40 object-cover rounded">
        @endif
        <h3 class="text-xl font-semibold mt-2 text-green-700">{{ $pet->name }}</h3>
        <p class="text-sm text-gray-600">{{ $pet->type }} | {{ $pet->gender }} | {{ $pet->age_group }} | Porte {{ $pet->size }}</p>
        <p class="text-xs text-gray-500 mt-1">Status: {{ $pet->status }}</p>
        <ul class="flex flex-wrap gap-1 mt-2 text-xs">
          @foreach(json_decode($pet->tags, true) as $tag)
            <li class="bg-green-100 text-green-800 px-2 py-1 rounded">{{ $tag }}</li>
          @endforeach
        </ul>

        <form action="{{ route('admin.pets.destroy', $pet) }}" method="POST" class="mt-3 flex justify-between">
          @csrf @method('DELETE')
          <button class="text-sm text-red-600 hover:underline">Excluir</button>
          <a href="{{ route('admin.pets.toggleStatus', $pet) }}" class="text-sm text-blue-600 hover:underline">
            {{ $pet->status === 'Adotado' ? 'Marcar como Disponível' : 'Marcar como Adotado' }}
          </a>
        </form>
      </div>
    @empty
      <p class="col-span-2 text-center text-gray-500">Nenhum pet cadastrado ainda.</p>
    @endforelse
  </div>
</section>
@endsection