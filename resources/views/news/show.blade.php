

@extends('layouts.app')

@section('title', $news->title)

@section('content')
  <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">{{ $news->title }}</h1>

    @if($news->image)
      <img src="{{ asset('storage/' . $news->image) }}" alt="{{ $news->title }}" class="w-full max-w-3xl mx-auto mb-4 rounded shadow">
    @endif

    <p class="text-gray-700 mb-4">{{ $news->description }}</p>

    <a href="{{ url()->previous() }}" class="inline-block bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900">Voltar</a>
  </div>
@endsection