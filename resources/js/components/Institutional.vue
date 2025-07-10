<template>
  <div class="institucional bg-[#143D26] font-sans">
    
    <!-- Nossa História -->
    <section class="bg-[#2D5236] text-white px-6 py-20">
      <div class="max-w-7xl mx-auto text-center">
        <h1 class="text-[36px] font-extrabold leading-tight mb-6">
          NOSSA <span class="italic font-thin">HISTÓRIA</span>
        </h1>
        <div class="my-8">
          <img src="/images/arara.png" alt="Arara" class="mx-auto rounded-xl shadow-lg w-full max-w-3xl" />
        </div>
        <h2 class="text-[24px] text-[#f2a532] font-extrabold mb-6">COMO TUDO COMEÇOU...</h2>
        <p class="text-[15px] leading-relaxed text-left max-w-5xl mx-auto">
          A ONG Bicho do Mato nasceu do amor pelos animais e da urgência em oferecer acolhimento a cães e gatos abandonados.<br><br>
          Desde sua fundação, atua no resgate, tratamento, castração e busca por lares responsáveis para animais em situação de risco.<br>
          Com o apoio de voluntários e doações, conseguimos transformar histórias de dor em finais felizes.<br>
          Nosso trabalho é movido pela empatia, compromisso e respeito à vida.<br>
          Mais do que uma ONG, somos uma rede de cuidado e esperança.<br>
          Cada ajuda recebida é um passo a mais na construção de um mundo mais justo para os animais.
        </p>
        <button class="mt-8 bg-[#f2a532] text-[#143D26] font-semibold px-10 py-2 rounded-full text-[16px] hover:bg-[#e19c2e] transition">
          VER MAIS
        </button>
      </div>
    </section>

    <!-- Missão, Visão, Valores -->
    <section class="relative bg-[#f2a532] text-[#143D26] px-6 py-20">
      <div class="max-w-7xl mx-auto space-y-16">
        
        <!-- MISSÃO -->
        <div class="flex items-start gap-6 text-left">
          <img src="/images/icons/missao.png" alt="Missão" class="w-12 h-12 mt-1" />
          <div>
            <h2 class="text-[24px] font-extrabold">MISSÃO</h2>
            <p class="text-[15px] leading-relaxed mt-3 max-w-5xl text-white">
              Resgatar, cuidar e promover a adoção responsável de animais em situação de abandono, oferecendo amor, tratamento e dignidade.
            </p>
          </div>
        </div>

        <!-- VISÃO -->
        <div class="flex items-start gap-6 text-right flex-row-reverse">
          <img src="/images/icons/visao.png" alt="Visão" class="w-12 h-12 mt-1" />
          <div>
            <h2 class="text-[24px] font-extrabold">VISÃO</h2>
            <p class="text-[15px] leading-relaxed mt-3 max-w-5xl text-white">
              Ser referência em proteção animal, ampliando o impacto social e construindo uma comunidade mais consciente e compassiva.
            </p>
          </div>
        </div>

        <!-- VALORES -->
        <div class="flex items-start gap-6 text-left">
          <img src="/images/icons/aperto-de-mao.png" alt="Valores" class="w-12 h-12 mt-1" />
          <div>
            <h2 class="text-[24px] font-extrabold mb-3">VALORES</h2>
            <ul class="text-[15px] leading-relaxed list-disc list-inside space-y-2 max-w-5xl text-white">
              <li>Amor e respeito pelos animais;</li>
              <li>Transparência e responsabilidade;</li>
              <li>Trabalho em equipe e voluntariado;</li>
              <li>Educação e conscientização;</li>
              <li>Adoção responsável e castração preventiva.</li>
            </ul>
          </div>
        </div>

      </div>
    </section>
  </div>
</template>

<script>
export default {
  name: "InstitucionalPage",
};
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;900&display=swap');

.institucional {
  font-family: 'Nunito', sans-serif;
}
</style>
