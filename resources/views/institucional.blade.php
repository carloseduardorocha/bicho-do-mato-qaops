@extends('layouts.app')

@section('title', 'Institucional')

@section('content')
<section class="max-w-4xl mx-auto py-8 px-4 relative">
  <h2 class="text-2xl font-semibold text-center mb-6 text-[#F3A632]">Como Tudo Começou...</h2>

  <div class="rounded-lg overflow-hidden mb-6">
    <img src="/images/header/Fundadores.jpg" alt="Fundadores Bicho do Mato" class="w-full object-cover rounded-xl aspect-square object-center">
  </div>
  <p class="text-center text-white text-sm mt-2">Fundadores: Izabel Antunes e Luiz Carlos Rodrigues</p>

  <p class="mb-4 text-justify text-[#F5E8D1]">
    A ONG Bicho do Mato nasceu do amor pelos animais e da urgência em oferecer acolhimento a cães e gatos abandonados.<br>
    Desde sua fundação, atua no resgate, tratamento, castração e busca por lares responsáveis para animais em situação de risco.<br>
    Com o apoio de voluntários e doações, conseguimos transformar histórias de dor em finais felizes.<br>
    Nosso trabalho é movido pela empatia, compromisso e respeito à vida.<br>
    Mais do que uma ONG, somos uma rede de cuidado e esperança.<br>
    Cada ajuda recebida é um passo a mais na construção de um mundo mais justo para os animais.
  </p>

  <div class="relative mt-6">
    <div class="bg-[#F3A632] rounded-lg p-6 space-y-4">
      <h3 class="text-xl font-semibold text-[#2F5233]">Amigo Pet</h3>
      <p class="text-justify text-white">
        Nossa ONG foi reconhecida pelo município como "Amigo Pet" em reconhecimento ao nosso trabalho e dedicação à causa animal, destacando nosso compromisso com o bem-estar dos animais de Frederico Westphalen.
      </p>
      <div class="flex flex-col md:flex-row md:space-x-4">
        <img src="/images/header/amigopetluiz.jpg" alt="Certificado Amigo Pet Luiz" class="w-full md:w-1/2 rounded-lg">
        <img src="/images/header/amigopetizabel.jpg" alt="Certificado Amigo Pet Izabel" class="w-full md:w-1/2 rounded-lg mt-4 md:mt-0">
      </div>
    </div>
  </div>

  <div class="relative mt-6">
    <div class="bg-[#F3A632] rounded-lg p-6 space-y-8">
      <div>
        <div class="flex items-center mb-2">
          <img src="/images/icons/missao.png" alt="Missão" class="w-10 h-10 mr-3">
          <h3 class="text-xl font-semibold text-[#2F5233]">Missão</h3>
        </div>
        <p class="text-justify text-white">
          Resgatar, cuidar e promover a adoção responsável de animais em situação de abandono, oferecendo amor, tratamento e dignidade.
        </p>
      </div>

      <div>
        <div class="flex items-center mb-2">
          <img src="/images/icons/visao.png" alt="Visão" class="w-10 h-10 mr-3">
          <h3 class="text-xl font-semibold text-[#2F5233]">Visão</h3>
        </div>
        <p class="text-justify text-white">
          Ser referência em proteção animal, ampliando o impacto social e construindo uma comunidade mais consciente e compassiva.
        </p>
      </div>

      <div>
        <div class="flex items-center mb-2">
          <img src="/images/icons/valores.png" alt="Valores" class="w-10 h-10 mr-3">
          <h3 class="text-xl font-semibold text-[#2F5233]">Valores</h3>
        </div>
        <ul class="list-disc pl-6 text-justify text-white">
          <li>Amor e respeito pelos animais;</li>
          <li>Transparência e responsabilidade;</li>
          <li>Trabalho em equipe e voluntariado;</li>
          <li>Educação e conscientização;</li>
          <li>Adoção responsável e castração preventiva.</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="mt-8">
    <h3 class="text-2xl font-bold text-white mb-4">VENHA NOS CONHECER</h3>
    <div class="w-full h-64 rounded-lg overflow-hidden mb-4">
      <iframe
        src="https://www.google.com/maps?q=-27.332029206292926,-53.38300863558247&hl=pt-BR&z=16&amp;output=embed"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
    <p class="text-[#F5E8D1]">Endereço: Vila Linha Iraí, S/N, Interior de Frederico Westphalen, 98.400-000.</p>
  </div>
</section>
@endsection