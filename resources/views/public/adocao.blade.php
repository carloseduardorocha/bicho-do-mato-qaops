@extends('layouts.app')

@section('title', 'Adote um Pet')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-bold mb-6">Adote um Pet</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($pets as $pet)
                <div class="bg-white shadow-md rounded p-4">
                    <img src="{{ asset('storage/pets/' . $pet->image) }}" alt="{{ $pet->name }}" class="w-full h-48 object-cover rounded mb-4">
                    <h2 class="text-xl font-semibold">{{ $pet->name }}</h2>
                    <p class="text-gray-600">Tipo: {{ $pet->type }}</p>
                    <p class="text-gray-600">Tamanho: {{ $pet->size }}</p>
                    <p class="text-gray-600">Sexo: {{ $pet->gender }}</p>
                </div>
            @empty
                <p class="text-gray-500">Nenhum pet disponível no momento.</p>
            @endforelse
        </div>
    </div>
@endsection