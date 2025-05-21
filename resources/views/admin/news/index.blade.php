@extends('layouts.app')

@section('title', 'Admin - Notícias')

@section('content')
<section class="max-w-5xl mx-auto py-8 px-4">
  <div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-semibold">Gerenciar Notícias</h2>
    <a href="{{ route('admin.news.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Nova Notícia</a>
  </div>

  @forelse ($noticias as $noticia)
    <div class="bg-white p-4 mb-4 rounded shadow">
      <h3 class="text-lg font-bold">{{ $noticia->title }}</h3>
      <p class="text-sm text-gray-600 mb-2">Autor: {{ $noticia->author }} | {{ $noticia->created_at->format('d/m/Y') }}</p>
      <p class="text-justify text-sm">{{ Str::limit($noticia->content, 180) }}</p>
      <form action="{{ route('admin.news.destroy', $noticia) }}" method="POST" class="mt-3">
        @csrf @method('DELETE')
        <button class="text-sm text-red-600 hover:underline">Excluir</button>
      </form>
    </div>
  @empty
    <p class="text-gray-500 text-center">Nenhuma notícia cadastrada.</p>
  @endforelse
</section>
@endsection