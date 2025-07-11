@extends('layouts.app')

@section('title', 'Página Inicial')

@section('content')
<div id="banner-home"></div>

<section class="bg-[#2F5233] py-8 px-4">
  <div class="relative bg-[#F5E8D1] rounded-lg shadow p-4">
    <div class="absolute -top-4 left-4 bg-[#F3A632] text-[#5C3A21] px-4 py-1 rounded-full">Notícias</div>

    <div class="flex items-center justify-between">
      <button class="bg-[#F3A632] text-[#5C3A21] rounded-full p-2">&lt;</button>

      <div class="flex-1 mx-4">
        @if($news->count())
          <div class="bg-yellow-50 rounded shadow p-4 text-center">
            @if($news[0]->image)
              <img src="{{ asset('storage/' . $news[0]->image) }}" alt="{{ $news[0]->title }}" class="w-full h-48 object-cover mb-2 rounded">
            @endif
            <h3 class="text-lg font-semibold text-green-900">{{ $news[0]->title }}</h3>
            <p class="text-gray-700 text-sm">{{ Str::limit($news[0]->description, 100) }}</p>
          </div>
        @else
          <p class="text-gray-500">Nenhuma notícia cadastrada no momento.</p>
        @endif
      </div>

      <button class="bg-[#F3A632] text-[#5C3A21] rounded-full p-2">&gt;</button>
    </div>

  </div>
</section>

<section class="bg-[#2F5233] py-8 px-4">
  <div class="relative bg-[#F5E8D1] rounded-lg shadow p-4">
    <div class="absolute -top-4 left-4 bg-[#F3A632] text-[#5C3A21] px-4 py-1 rounded-full">Depoimentos</div>

    <div class="flex items-center justify-between">
      <button class="bg-[#F3A632] text-[#5C3A21] rounded-full p-2">&lt;</button>

      <div class="flex-1 mx-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse ($testimonials as $testimonial)
          <div class="bg-white rounded shadow p-4 text-center">
            @if($testimonial->image_path)
              <img src="{{ asset('storage/' . $testimonial->image_path) }}" alt="{{ $testimonial->name }}" class="w-24 h-24 mx-auto rounded-full mb-4">
            @endif
            <h3 class="text-lg font-semibold">{{ $testimonial->name }}</h3>
            <p class="text-gray-700 text-sm mt-2">"{{ $testimonial->message }}"</p>
          </div>
        @empty
          <p class="text-gray-500">Nenhum depoimento cadastrado no momento.</p>
        @endforelse
      </div>

      <button class="bg-[#F3A632] text-[#5C3A21] rounded-full p-2">&gt;</button>
    </div>

    <div class="flex justify-center mt-[-1.5rem] relative -bottom-6">
      <a href="{{ route('testimonials.index') }}"
         class="bg-[#F3A632] text-[#5C3A21] px-6 py-2 rounded-full hover:bg-yellow-600 uppercase text-center"
      >VER MAIS</a>
    </div>
  </div>
</section>

<section class="bg-[#2F5233] py-8 px-4">
  <div class="relative bg-[#F5E8D1] rounded-lg shadow p-4">
    <div class="absolute -top-4 left-4 bg-[#F3A632] text-[#5C3A21] px-4 py-1 rounded-full">Nossos Parceiros</div>

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
        <p class="text-gray-700">Nenhum parceiro cadastrado no momento.</p>
      @endforelse
    </div>

    <div class="flex justify-center mt-[-1.5rem] relative -bottom-6">
      <a href="{{ route('partners.index') }}"
         class="bg-[#F3A632] text-[#5C3A21] px-6 py-2 rounded-full hover:bg-yellow-600 uppercase text-center"
      >VER MAIS</a>
    </div>
  </div>
</section>

<section class="bg-[#2F5233] py-8 px-4">
  <div class="relative bg-[#F5E8D1] rounded-lg shadow p-4">
    <div class="absolute -top-4 left-4 bg-[#F3A632] text-[#5C3A21] px-4 py-1 rounded-full">Redes Sociais</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
      <div class="bg-white rounded shadow p-4">
        <p class="text-green-800 font-bold mt-2 mb-2">Instagram</p>
        <div class="w-16 h-16 mx-auto mb-2 rounded-full bg-green-800 flex items-center justify-center">
          <img src="{{ asset('images/icons/Instagram_icon.png') }}" alt="Instagram" class="w-8 h-8">
        </div>
        <p class="text-green-800 font-bold">@bichodomato</p>
        <a href="https://www.instagram.com/ongbichodomato/"
           target="_blank"
           class="mt-2 inline-block bg-[#2F5233] text-[#F3A632] px-4 py-2 rounded-full hover:bg-green-700">
          SEGUIR
        </a>
      </div>

      <div class="bg-white rounded shadow p-4">
        <p class="text-green-800 font-bold mt-2 mb-2">Facebook</p>
        <div class="w-16 h-16 mx-auto mb-2 rounded-full bg-green-800 flex items-center justify-center">
          <img src="{{ asset('images/icons/facebook_icon.png') }}" alt="Facebook" class="w-8 h-8">
        </div>
        <p class="text-green-800 font-bold">@bichodomato</p>
        <a href="https://www.facebook.com/bichodomatofw"
           target="_blank"
           class="mt-2 inline-block bg-[#2F5233] text-[#F3A632] px-4 py-2 rounded-full hover:bg-green-700">
          SEGUIR
        </a>
      </div>

      <div class="bg-white rounded shadow p-4">
        <p class="text-green-800 font-bold mt-2 mb-2">TikTok</p>
        <div class="w-16 h-16 mx-auto mb-2 rounded-full bg-green-800 flex items-center justify-center">
          <img src="{{ asset('images/icons/tiktok-icon-black.svg') }}" alt="TikTok" class="w-8 h-8">
        </div>
        <p class="text-green-800 font-bold">@bichodomato</p>
        <a href="https://www.tiktok.com/@ongbichodomato" target="_blank" class="mt-2 inline-block bg-[#2F5233] text-[#F3A632] px-4 py-2 rounded-full hover:bg-green-700">SEGUIR</a>
      </div>
    </div>

    <div class="flex justify-center mt-[-1.5rem] relative -bottom-6">
      <a href="#"
         class="bg-[#F3A632] text-[#5C3A21] px-6 py-2 rounded-full hover:bg-yellow-600 uppercase text-center"
      >VER MAIS</a>
    </div>
  </div>
</section>


<section class="bg-[#2F5233] py-8 px-4">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-[#F5E8D1] rounded shadow p-4 text-[#5C3A21]">
      <h3 class="font-bold mb-2">Entre em <span class="font-extrabold">contato conosco:</span></h3>
      <div class="flex items-center bg-white rounded px-2 py-1 mb-2">
        <img src="{{ asset('images/icons/telefone icon.png') }}" alt="Telefone" class="w-6 h-6 mr-2">
        <img src="{{ asset('images/icons/wattswapp mini icon.png') }}" alt="WhatsApp" class="w-6 h-6 mr-2">
        <span>(55) 90000-0000 | 3600-0000</span>
      </div>
      <div class="flex items-center bg-white rounded px-2 py-1 mb-2">
        <img src="{{ asset('images/icons/Facebook mini Icon.svg') }}" alt="Facebook" class="w-6 h-6 mr-2">
        <span>bichodomato.org</span>
      </div>
      <div class="flex items-center bg-white rounded px-2 py-1">
        <img src="{{ asset('images/icons/mail_icon.png') }}" alt="Email" class="w-6 h-6 mr-2">
        <span>ong@bichodomato.org</span>
      </div>
    </div>
    <div class="bg-[#F5E8D1] rounded shadow p-4 text-[#5C3A21]">
      <h3 class="font-bold mb-2">Onde estamos:</h3>
      <iframe
        class="w-full h-48 object-cover mt-2 rounded"
        frameborder="0"
        style="border:0"
        src="https://www.google.com/maps/embed/v1/view?key=YOUR_GOOGLE_MAPS_API_KEY&center=-27.348574237352228,-53.39327503274598&zoom=18"
        allowfullscreen>
      </iframe>
    </div>
  </div>
</section>
@endsection

@vite('resources/js/blade-vue.ts')