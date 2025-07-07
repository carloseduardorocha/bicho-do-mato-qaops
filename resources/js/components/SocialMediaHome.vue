<template>
  <section class="py-16 px-4">
    <div class="relative max-w-5xl mx-auto">
      <!-- Título -->
      <div class="absolute -top-4 left-4 bg-[#f2a532] text-[#714d2e] px-10 py-3 rounded-md text-3xl font-bold shadow z-10">
        REDES SOCIAIS
      </div>

      <!-- Container -->
      <div class="bg-[#fff5e1] rounded-3xl shadow-md pt-24 px-12 flex flex-col md:flex-row justify-between gap-10 min-h-[620px]">
        <!-- Instagram -->
        <div class="flex-1 text-center flex flex-col items-center">
          <p class="text-xl font-extrabold text-[#1c3c2c] mb-4">Instagram</p>
          <img
            src="/images/instagram.jpg"
            class="w-64 h-64 rounded-full border-6 border-[#f2a532] object-cover"
          />
          <p class="mt-6 text-lg text-[#1c3c2c] font-semibold">@nossaempresa_insta</p>
          <a
            href="https://instagram.com/nossaempresa_insta"
            target="_blank"
            class="mt-4 bg-[#1c3c2c] text-[#f2a532] px-6 py-3 rounded-full font-bold hover:bg-[#285040] transition"
          >
            SEGUIR
          </a>
        </div>

        <!-- Facebook -->
        <div class="flex-1 text-center flex flex-col items-center">
          <p class="text-xl font-extrabold text-[#1c3c2c] mb-4">Facebook</p>
          <img
            src="/images/facebook.jpg"
            class="w-64 h-64 rounded-full border-6 border-[#f2a532] object-cover"
          />
          <p class="mt-6 text-lg text-[#1c3c2c] font-semibold">@nossaempresa_fb</p>
          <a
            href="https://facebook.com/nossaempresa_fb"
            target="_blank"
            class="mt-4 bg-[#1c3c2c] text-[#f2a532] px-6 py-3 rounded-full font-bold hover:bg-[#285040] transition"
          >
            SEGUIR
          </a>
        </div>

        <!-- TikTok -->
        <div class="flex-1 text-center flex flex-col items-center">
          <p class="text-xl font-extrabold text-[#1c3c2c] mb-4">TikTok</p>
          <img
            src="/images/tiktok.jpg"
            class="w-64 h-64 rounded-full border-6 border-[#f2a532] object-cover"
          />
          <p class="mt-6 text-lg text-[#1c3c2c] font-semibold">@nossaempresa_tiktok</p>
          <a
            href="https://tiktok.com/@nossaempresa_tiktok"
            target="_blank"
            class="mt-4 bg-[#1c3c2c] text-[#f2a532] px-6 py-3 rounded-full font-bold hover:bg-[#285040] transition"
          >
            SEGUIR
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
  font-weight: 700;
  background-color: transparent;
}
</style>
