@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div id="banner-home"></div>

<section class="bg-green-900 py-8 px-4">
  <div class="bg-white rounded-lg shadow p-4">
    <h2 class="text-2xl font-bold text-green-900 mb-4">Notícias</h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      @forelse ($news as $item)
        <div class="bg-gray-100 rounded shadow overflow-hidden">
          @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-48 object-cover">
          @endif
          <div class="p-4">
            <h3 class="text-lg font-semibold">{{ $item->title }}</h3>
            <p class="text-gray-700 text-sm">{{ Str::limit($item->description, 100) }}</p>
          </div>
        </div>
      @empty
        <p class="text-gray-500">Nenhuma notícia cadastrada no momento.</p>
      @endforelse
    </div>

    <div class="text-center mt-4">
      <a href="{{ route('news.index') }}" class="inline-block bg-green-800 text-white px-6 py-2 rounded hover:bg-green-900">Ver mais</a>
    </div>
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

<section class="bg-green-700 py-8 px-4">
  <h2 class="text-2xl font-bold text-yellow-200 mb-4">Nossos Parceiros</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    @forelse ($partners as $partner)
      <div class="bg-white rounded shadow p-4 text-center">
        @if($partner->logo)
          <img src="{{ asset('storage/' . $partner->logo) }}" alt="{{ $partner->name }}" class="w-24 h-24 mx-auto rounded mb-4">
        @endif
        <h3 class="text-lg font-semibold">{{ $partner->name }}</h3>
        <p class="text-gray-700 text-sm mt-2">{{ $partner->cnpj }}</p>
      </div>
    @empty
      <p class="text-white">Nenhum parceiro cadastrado no momento.</p>
    @endforelse
  </div>
</section>

<section class="bg-green-600 py-8 px-4">
  <h2 class="text-2xl font-bold text-yellow-100 mb-4">Redes Sociais</h2>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
    <div class="bg-white rounded shadow p-4">
      <img src="{{ asset('images/header/icons/icon-instagram.png') }}" alt="Instagram" class="w-16 h-16 mx-auto mb-2">
      <p class="text-green-800 font-bold">@bichodomato</p>
      <a href="#" class="mt-2 inline-block bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900">SEGUIR</a>
    </div>

    <div class="bg-white rounded shadow p-4">
      <img src="{{ asset('images/header/icons/icon-facebook.svg') }}" alt="Facebook" class="w-16 h-16 mx-auto mb-2">
      <p class="text-green-800 font-bold">@bichodomato</p>
      <a href="#" class="mt-2 inline-block bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900">SEGUIR</a>
    </div>

    <div class="bg-white rounded shadow p-4">
      <img src="{{ asset('images/header/icons/icon-tiktok.png') }}" alt="TikTok" class="w-16 h-16 mx-auto mb-2">
      <p class="text-green-800 font-bold">@bichodomato</p>
      <a href="#" class="mt-2 inline-block bg-green-800 text-white px-4 py-2 rounded hover:bg-green-900">SEGUIR</a>
    </div>
  </div>
</section>

<section class="bg-green-800 py-8 px-4">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div>
      <h2 class="text-2xl font-bold text-yellow-300 mb-4">Entre em contato conosco</h2>
      <p class="text-white mb-2"><i class="fas fa-phone"></i> (55) 90000-0000 | 3600-0000</p>
      <p class="text-white mb-2"><i class="fas fa-globe"></i> bichodomato.org</p>
      <p class="text-white mb-2"><i class="fas fa-envelope"></i> ong@bichodomato.org</p>
    </div>
    <div>
      <h2 class="text-2xl font-bold text-yellow-300 mb-4">Onde estamos</h2>
      <div class="relative bg-white rounded shadow p-4">
        <img src="{{ asset('images/home/map-home.png') }}" alt="Mapa localização" class="w-full rounded">
        <a href="https://wa.me/559900000000" target="_blank" class="absolute bottom-4 right-4">
          <img src="{{ asset('images/header/icons/icon-whatsapp.png') }}" alt="WhatsApp" class="w-16 h-16">
        </a>
      </div>
    </div>
  </div>
</section>

<footer class="bg-green-900 py-6 px-4 text-center text-white">
  <p class="mb-2">Endereço: Rua Exemplo, 123 - Cidade/UF</p>
  <p class="mb-2">WhatsApp: (55) 99999-9999</p>
  <p class="mb-4">Email: contato@bichodomato.org</p>
  <p class="text-sm">&copy; {{ date('Y') }} Bicho do Mato. Todos os direitos reservados.</p>
</footer>

@endsection

@vite('resources/js/blade-vue.ts')