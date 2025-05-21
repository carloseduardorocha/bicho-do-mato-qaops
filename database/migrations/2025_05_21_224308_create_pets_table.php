@extends('layouts.app')

@section('title', 'Adote um Pet')

@section('content')
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Pets disponíveis para adoção</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      @forelse ($pets as $pet)
        <div class="bg-white rounded shadow p-4">
          <h2 class="text-lg font-semibold">{{ $pet->name ?? 'Nome não informado' }}</h2>
          <p class="text-gray-700">{{ $pet->description ?? 'Sem descrição' }}</p>
          <p class="text-sm text-gray-500">Tamanho: {{ $pet->size ?? 'Desconhecido' }}</p>
        </div>
      @empty
        <p class="text-gray-500">Nenhum pet disponível no momento.</p>
      @endforelse
    </div>
  </div>
@endsection
