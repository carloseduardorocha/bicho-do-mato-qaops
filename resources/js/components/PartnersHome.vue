<template>
  <section class="py-16 px-4">
    <div class="relative max-w-4xl mx-auto">
      <!-- Título -->
      <div class="absolute -top-4 left-4 bg-[#f2a532] text-[#714d2e] px-10 py-3 rounded-md text-3xl font-bold shadow z-10">
        NOSSOS PARCEIROS
      </div>

      <!-- Container centralizado e arredondado -->
      <div class="bg-[#fff5e1] rounded-3xl shadow-md pt-24 px-12 flex flex-col md:flex-row justify-between gap-14 min-h-[600px]">
        <!-- Parceiro 1 -->
        <div class="flex-1 text-center">
          <img
            src="/images/parceiro1.jpg"
            class="w-72 h-72 rounded-full mx-auto border-6 border-[#f2a532] object-cover"
          />
          <p class="mt-8 text-xl font-extrabold text-[#1c3c2c]">Empresa Alpha</p>
          <p class="mt-2 text-[#1c3c2c] text-lg">CNPJ: 00.000.000/0000-00</p>
        </div>

        

        <!-- Parceiro 2 -->
        <div class="flex-1 text-center">
          <img
            src="/images/parceiro2.jpg"
            class="w-72 h-72 rounded-full mx-auto border-6 border-[#f2a532] object-cover"
          />
          <p class="mt-8 text-xl font-extrabold text-[#1c3c2c]">Beta Comércio</p>
          <p class="mt-2 text-[#1c3c2c] text-lg">CNPJ: 00.000.000/0000-00</p>
        </div>
      </div>

  <!-- Botão Ver Mais -->
      <div class="mt-8 text-center">
        <a
          href="/parceiros"
          class="inline-block bg-[#f2a532] text-[#714d2e] italic font-semibold px-10 py-3 rounded-full hover:bg-[#d18c1f] transition"
        >
          VER MAIS
        </a>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
// Sem lógica dinâmica por enquanto
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');

section {
  font-family: 'Nunito-Bold', sans-serif;
  
  background-color: transparent;
}
</style>
