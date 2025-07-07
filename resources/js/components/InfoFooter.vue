<template>
  <section class="py-16 px-4" style="background-color: #2f5233">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
      <!-- Coluna esquerda - Contato -->
      <div class="space-y-8">
        <div class="text-white text-3xl leading-tight">
          <p class="font-normal">Entre em</p>
          <p class="font-extrabold">contato conosco</p>
        </div>

        <div class="bg-[#fff5e1] text-[#1c3c2c] rounded-full px-6 py-4 shadow w-full">
           +00 (00) 0000-0000
        </div>
        <div class="bg-[#fff5e1] text-[#1c3c2c] rounded-full px-6 py-4 shadow w-full">
           facebook.com/bichodonato
        </div>
        <div class="bg-[#fff5e1] text-[#1c3c2c] rounded-full px-6 py-4 shadow w-full">
           contato@bichodonato.org
        </div>
      </div>

      <!-- Coluna direita - Mapa + WhatsApp -->
      <div class="space-y-8">
       <div class="text-white text-3xl leading-tight">
          <p class="font-normal">Onde</p>
          <p class="font-extrabold">estamos</p>
        </div>


        <div class="flex flex-col md:flex-row items-center gap-6">
          <!-- Mapa -->
          <div class="w-full md:w-72 h-44 overflow-hidden rounded-xl shadow">
            <iframe
              class="w-full h-full"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!..." 
              style="border:0;"
              allowfullscreen="true"
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>

          <!-- WhatsApp -->
          <a
            href=""
            target="_blank"
            class="bg-[#25D366] p-5 rounded-full shadow-lg hover:scale-105 transition"
            title="Fale conosco pelo WhatsApp"
          >
            <svg width="64" height="64" viewBox="0 0 24 24" fill="#fff">
              <path d="M17.472 14.382c-..." />
            </svg>
          </a>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup lang="ts">
// Nenhuma lógica dinâmica por enquanto
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');

section {
  font-family: 'Nunito', sans-serif;
}
</style>
