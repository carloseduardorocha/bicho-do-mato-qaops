@extends('layouts.app')

@section('title', 'Como Ajudar')

@section('content')
<section class="text-center py-8 px-4" style="background-color: #2F5233;">
  <h2 class="text-4xl font-bold text-center mb-4 text-white">COMO <span class="italic">AJUDAR?</span></h2>

  <div class="flex justify-center mb-6">
    <img src="/images/header/cachorroadocao.jpg" alt="Cachorro para adoção" class="rounded-lg shadow-md object-cover w-full max-w-md h-[500px]">
  </div>

  <h3 class="text-left text-yellow-500 text-4xl font-bold mb-4 max-w-xl mx-auto">TEM UM AMIGO QUE PRECISA DE VOCÊ.</h3>
  <div class="text-left max-w-xl mx-auto mb-4 text-[#F5E8D1]">
    <p class="mb-4">
      <strong>Ajude a ONG Bicho do Mato!</strong><br>
      A ONG Bicho do Mato trabalha todos os dias para resgatar, cuidar e dar uma nova chance a animais em situação de risco. E você pode fazer parte dessa missão!
    </p>
    <p class="mb-2">Existem várias formas de apoiar:</p>
    <ul class="list-disc pl-5 mb-4">
      <li><strong>Doações:</strong> contribua com qualquer valor ou com itens como ração, medicamentos e materiais de limpeza.</li>
      <li><strong>Adoções:</strong> abra seu coração e sua casa para um dos nossos animais.</li>
      <li><strong>Voluntariado:</strong> venha ajudar nos cuidados diários, eventos e campanhas de conscientização.</li>
      <li><strong>Apadrinhamento:</strong> ajude a manter um animalzinho até ele encontrar um lar.</li>
    </ul>
    <p class="mb-4">
      <strong>Quer ser voluntário ou apoiar de outra forma?</strong><br>
      Entre em contato com a gente diretamente pelo app ou pelas nossas redes sociais!
    </p>
    <p><em>Juntos, podemos transformar vidas.</em></p>
  </div>

  <div class="relative flex justify-center mb-14">
    <img src="/images/header/adotepet.jpg" alt="Adote agora" class="rounded-lg shadow-md w-full max-w-md">
    <a href="https://wa.me/5555996219405" target="_blank" class="absolute left-1/2 transform -translate-x-1/2 bottom-0 translate-y-1/2 bg-[#F3A632] text-white px-6 py-3 rounded-full font-bold hover:bg-yellow-500 items-center justify-center shadow-md text-lg flex" style="border-radius: 30px;">
      <span class="italic mr-1">ADOTE</span> <span class="font-extrabold">AGORA</span>
      <img src="/images/icons/wattsapp-grande.png" alt="WhatsApp" class="w-8 h-8 ml-3">
    </a>
  </div>

  <div class="bg-[#F3A632] text-white p-4 rounded-lg max-w-md mx-auto mb-6">
    <h3 class="text-xl font-bold mb-4 text-center">VENHA FAZER PARTE DESSA CORRENTE!</h3>
    <div class="flex justify-center mb-4 space-x-2">
      <img src="/images/header/bazarodoar.jpg" alt="Bazar Doar" class="rounded-lg shadow-md w-28 h-28 object-cover">
      <img src="/images/header/bazardog.jpg" alt="Bazar Dog" class="rounded-lg shadow-md w-28 h-28 object-cover">
      <img src="/images/header/acao_grenal.jpg" alt="Ação Grenal" class="rounded-lg shadow-md w-28 h-28 object-cover">
    </div>
    <p class="text-sm mb-2">Nossa ONG realiza bazares, ações de arrecadação de fundos e campanhas de doação com apoio de diversas entidades, grupos e empresas que acreditam no nosso propósito.</p>
    <p class="text-sm mb-2">Cada evento, bazar ou ação solidária gera recursos essenciais para manter nossos animais bem cuidados, além de fortalecer a corrente do bem e envolver cada vez mais pessoas nessa causa.</p>
    <p class="text-sm mb-2">Seja um voluntário, participe das nossas feiras, ações de arrecadação ou apadrinhe um de nossos animais. Sua ajuda faz a diferença!</p>
  </div>

  <div class="bg-green-800 p-4 rounded-lg mb-6 max-w-md mx-auto text-left">
    <h3 class="text-lg font-bold mb-2 text-white">Entre em contato conosco:</h3>
    <div class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded mb-2 flex flex-col">
      <div class="flex items-center mb-1">
        <img src="/images/icons/wattswapp mini icon.png" alt="WhatsApp" class="w-6 h-6 mr-2">
        <a href="https://wa.me/5555996219405" target="_blank" class="text-[#2F5233]">(55) 9.9621-9405</a>
      </div>
      <div class="flex items-center">
        <img src="/images/icons/wattswapp mini icon.png" alt="WhatsApp" class="w-6 h-6 mr-2">
        <a href="https://wa.me/5555999946201" target="_blank" class="text-[#2F5233]">(55) 9.9994-6201</a>
      </div>
    </div>
    <a href="https://www.facebook.com/messages/t/bichodomatofw" target="_blank" class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded mb-2 flex items-center">
      <img src="/images/icons/Facebook mini icon.svg" class="inline w-5 h-5 mr-2"> bichodomato.org
    </a>
    <a href="https://www.instagram.com/ongbichodomato/" target="_blank" class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded mb-2 flex items-center">
      <img src="/images/icons/Instagram_icon.png" class="inline w-5 h-5 mr-2"> @ongbichodomato
    </a>
    <a href="mailto:bug_alarme@hotmail.com" class="bg-[#F5E8D1] text-[#2F5233] p-2 rounded flex items-center">
      <img src="/images/icons/mail_icon.png" class="inline w-5 h-5 mr-2"> bug_alarme@hotmail.com
    </a>
  </div>

  <div class="bg-[#F3A632] text-white p-4 rounded-lg max-w-md mx-auto">
    <h3 class="text-lg font-bold mb-2 text-white">FAÇA SUA DOAÇÃO!</h3>
    <p class="text-sm mb-2">Pix: 29.714.162/0001-73</p>
    <p class="text-sm mb-4">Depósito Bancário: Banrisul Agência: 0630 - C/C: 06.081.453.09</p>
    <img src="/images/pix/qrcode-pix.png" alt="QR Code Pix" class="mx-auto h-40 mb-4 mt-4">
    <p class="text-sm mb-2">Beneficiário: CNPJ: 29.714.162/0001-73 (Santuário de Defesa Animal Bicho do Mato)</p>
    <p class="text-xs mt-2">Doe qualquer valor e nos ajude a cuidar dos nossos animais resgatados. Sua contribuição faz a diferença!</p>
  </div>
</section>
@endsection