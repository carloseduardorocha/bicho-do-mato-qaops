@extends('layouts.app')

@section('title', 'Como Ajudar')

@section('content')
<section class="text-center py-8">
  <h2 class="text-2xl font-semibold">Ajude a ONG Bicho do Mato</h2>
  <p class="max-w-xl mx-auto mt-2">Você pode apoiar com doações via Pix, divulgar nossos projetos, tornar-se voluntário ou adotar um pet.</p>

  <div class="mt-6">
    <h3 class="text-lg font-medium mb-2">Doações via Pix</h3>
    <img src="{{ Vite::asset('resources/images/pix/qrcode-pix.png') }}" alt="QR Code Pix" class="mx-auto h-40">
    <p class="text-sm mt-2">Chave Pix: contato@bichodomato.org.br</p>
  </div>

  <div class="mt-6">
    <h3 class="text-lg font-medium mb-2">Entre em contato</h3>
    <a href="https://wa.me/559999999999" target="_blank" class="inline-block bg-green-600 text-white px-6 py-2 rounded mt-2 hover:bg-green-700">Fale com a gente no WhatsApp</a>
  </div>
</section>
@endsection