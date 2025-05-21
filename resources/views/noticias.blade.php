@extends('layouts.app')

@section('title', 'Notícias')

@section('content')
<section class="max-w-4xl mx-auto py-8 px-4">
  <h2 class="text-2xl font-semibold mb-6 text-center">Notícias e Atualizações</h2>

  {{-- Aqui será renderizada a lista de notícias via controller --}}
  @forelse($noticias as $noticia)
    <article class="mb-6 bg-white p-4 rounded shadow">
      @if($noticia->image_path)
        <img src="{{ asset('storage/' . $noticia->image_path) }}" alt="{{ $noticia->title }}" class="w-full h-48 object-cover rounded mb-3">
      @endif
      <h3 class="text-xl font-semibold">{{ $noticia->title }}</h3>
      <p class="text-sm text-gray-600">Publicado por {{ $noticia->author }} em {{ $noticia->created_at->format('d/m/Y') }}</p>
      <p class="mt-2 text-justify">{{ $noticia->content }}</p>
    </article>
  @empty
    <p class="text-center text-gray-500">Nenhuma notícia cadastrada.</p>
  @endforelse
</section>
@endsection