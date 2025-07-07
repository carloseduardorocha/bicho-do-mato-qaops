<template>
  <section class="py-16 px-4">
    <div class="relative max-w-4xl mx-auto">
      <!-- Título -->
      <div class="absolute -top-4 left-4 bg-[#f2a532] text-[#714d2e] px-8 py-3 rounded-md text-2xl font-bold shadow z-10">
        DEPOIMENTOS
      </div>

      <!-- Container Depoimentos -->
      <div class="bg-[#fff5e1] rounded-3xl shadow-md pt-20 px-10 flex flex-col md:flex-row justify-between gap-10 min-h-[520px]">
        
        <div class="flex-1 text-center">
          <img
            src="/images/avatar1.jpg"
            class="w-50 h-50 rounded-full mx-auto border-4 border-[#f2a532] object-cover"
          />
          <p class="mt-6 text-base font-extrabold text-[#1c3c2c]">Gilberto Souza</p>
          <p class="mt-4 text-[#1c3c2c] text-sm">
            Graças ao app, encontrei o melhor amigo que eu poderia ter!
          </p>
        </div>

        
        <div class="hidden md:block w-px bg-[#a3a3a3] mx-4"></div>

        
        <div class="flex-1 text-center">
          <img
            src="/images/avatar2.jpg"
            class="w-50 h-50 rounded-full mx-auto border-4 border-[#f2a532] object-cover"
          />
          <p class="mt-6 text-base font-extrabold text-[#1c3c2c]">Cintia da Silva</p>
          <p class="mt-4 text-[#1c3c2c] text-sm">
            Adotar o Thor foi uma das melhores decisões da minha vida. O aplicativo facilitou todo o processo...
          </p>
        </div>
      </div>

      <!-- Botão Ver Mais -->
      <div class="mt-8 text-center">
        <a
          href="/depoimentos"
          class="inline-block bg-[#f2a532] text-[#714d2e] italic font-semibold px-10 py-3 rounded-full hover:bg-[#d18c1f] transition"
        >
          VER MAIS
        </a>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
// Nenhuma lógica dinâmica por enquanto
</script>

<style scoped>
section {
  font-family: 'Nunito-Bold', sans-serif;

  background-color: transparent;
}
</style>
