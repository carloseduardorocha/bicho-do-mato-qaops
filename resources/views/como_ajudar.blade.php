@extends('layouts.app')

@section('title', 'Como Ajudar')

@section('content')
<section class="text-center py-8 px-4" style="background-color: #2F5233;">
  <h2 class="text-4xl font-bold text-center mb-4 text-white">COMO <span class="italic">AJUDAR?</span></h2>

  <div class="flex justify-center mb-6">
    <img src="{{ Vite::asset('resources/images/header/ajude-dog.jpg') }}" alt="Cachorro para adoção" class="rounded-lg shadow-md w-full max-w-md">
  </div>

  <h3 class="text-center text-yellow-500 text-3xl font-bold mb-2">TEM UM AMIGO QUE PRECISA DE VOCÊ.</h3>
  <p class="text-left max-w-xl mx-auto mb-4 text-[#F5E8D1]">
    <strong>Ajude a ONG Bicho do Mato!</strong><br>
    A ONG Bicho do Mato trabalha todos os dias para resgatar, cuidar e dar uma nova chance a animais em situação de risco. E você pode fazer parte dessa missão!<br><br>
    Existem várias formas de apoiar:<br>
    <strong>Doações:</strong> contribua com qualquer valor ou com itens como ração, medicamentos e materiais de limpeza.<br>
    <strong>Adoções:</strong> abra seu coração e sua casa para um dos nossos animais.<br>
    <strong>Voluntariado:</strong> venha ajudar nos cuidados diários, eventos e campanhas de conscientização.<br>
    <strong>Apadrinhamento:</strong> ajude a manter um animalzinho até ele encontrar um lar.<br><br>
    <strong>Quer ser voluntário ou apoiar de outra forma?</strong><br>
    Entre em contato com a gente diretamente pelo app ou pelas nossas redes sociais!<br><br>
    <em>Juntos, podemos transformar vidas.</em>
  </p>

  <div class="flex justify-center mb-6">
    <img src="{{ Vite::asset('resources/images/header/adote-agora.jpg') }}" alt="Adote agora" class="rounded-lg shadow-md w-full max-w-md">
  </div>

  <a href="https://wa.me/559900000000" target="_blank" class="inline-flex bg-yellow-400 text-brown-800 px-6 py-3 rounded-full font-bold hover:bg-yellow-500 mb-8 items-center justify-center shadow-md text-lg" style="border-radius: 30px;">
    <span class="italic mr-1">ADOTE</span> <span class="font-extrabold">AGORA</span>
    <img src="/images/icons/wattsapp-grande.png" alt="WhatsApp" class="w-8 h-8 ml-3">
  </a>

  <div class="bg-green-800 p-4 rounded-lg mb-6 max-w-md mx-auto text-left">
    <h3 class="text-lg font-bold mb-2 text-white">Entre em contato conosco:</h3>
    <div class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded mb-2 flex items-center">
      <img src="/images/icons/telefone icon.png" class="inline w-5 h-5 mr-2"> (55) 90000-0000 | 3600-0000
    </div>
    <div class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded mb-2 flex items-center">
      <img src="/images/icons/Facebook mini icon.svg" class="inline w-5 h-5 mr-2"> bichodomato.org
    </div>
    <div class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded flex items-center">
      <img src="/images/icons/mail_icon.png" class="inline w-5 h-5 mr-2"> ong@bichodomato.org
    </div>
  </div>

  <div class="bg-yellow-400 text-brown-800 p-4 rounded-lg max-w-md mx-auto">
    <h3 class="text-lg font-bold mb-2">FAÇA SUA DOAÇÃO!</h3>
    <p class="text-sm mb-2">PIX - CNPJ: 29.714.162/0001-73 (Santuário de Defesa Animal Bicho do Mato)</p>
    <img src="{{ Vite::asset('resources/images/pix/qrcode-pix.png') }}" alt="QR Code Pix" class="mx-auto h-40">
    <p class="text-xs mt-2">Doe qualquer valor e nos ajude a cuidar dos nossos animais resgatados. Sua contribuição faz a diferença!</p>
  </div>
</section>
@endsection