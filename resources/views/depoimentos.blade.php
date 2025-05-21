@extends('layouts.app')

@section('title', 'Depoimentos')

@section('content')
<section class="max-w-4xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-semibold text-center mb-6">Relatos de Quem Já Ajudou ou Foi Ajudado</h2>

  <div class="grid md:grid-cols-2 gap-6">
    @forelse($depoimentos as $depoimento)
      <div class="bg-white p-4 rounded shadow text-center">
        @if($depoimento->image_path)
          <img src="{{ asset('storage/' . $depoimento->image_path) }}" alt="{{ $depoimento->name }}" class="w-24 h-24 rounded-full mx-auto mb-3 object-cover">
        @endif
        <h3 class="font-semibold">{{ $depoimento->name }}</h3>
        <p class="text-sm text-gray-700 mt-2">{{ $depoimento->message }}</p>
      </div>
    @empty
      <p class="col-span-2 text-center text-gray-500">Nenhum depoimento cadastrado ainda.</p>
    @endforelse
  </div>
</section>
@endsection