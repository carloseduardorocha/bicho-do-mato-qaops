@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div id="banner-home"></div>

<section class="bg-green-900 py-8 px-4">
  <h2 class="text-2xl font-bold text-yellow-400 mb-4">Notícias</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @forelse ($news as $item)
      <div class="bg-white rounded shadow overflow-hidden">
        @if($item->image)
          <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
        @endif
        <div class="p-4">
          <h3 class="text-lg font-semibold">{{ $item->title }}</h3>
          <p class="text-gray-700 text-sm">{{ Str::limit($item->description, 100) }}</p>
          <a href="{{ route('news.show', $item->id) }}" class="text-green-800 font-bold mt-2 inline-block">Ver mais</a>
        </div>
      </div>
    @empty
      <p class="text-white">Nenhuma notícia cadastrada no momento.</p>
    @endforelse
  </div>
</section>

<section class="bg-green-800 py-8 px-4">
  <h2 class="text-2xl font-bold text-yellow-300 mb-4">Depoimentos</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @forelse ($testimonials as $testimonial)
      <div class="bg-white rounded shadow p-4 text-center">
        @if($testimonial->image_path)
          <img src="{{ asset('storage/' . $testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-24 h-24 mx-auto rounded-full mb-4">
        @endif
        <h3 class="text-lg font-semibold">{{ $testimonial->name }}</h3>
        <p class="text-gray-700 text-sm mt-2">"{{ $testimonial->message }}"</p>
      </div>
    @empty
      <p class="text-white">Nenhum depoimento cadastrado no momento.</p>
    @endforelse
  </div>
</section>

@endsection

@vite('resources/js/blade-vue.ts')