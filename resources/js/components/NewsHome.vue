<template>
  <div class="news-carousel max-w-4xl mx-auto relative select-none px-4 py-8">
   
    <div
      class="news-title bg-[#f2a532] text-[#714d2e] font-semibold text-2xl px-6 py-2 rounded-t-lg select-none"
      style="font-family: 'Nunito', sans-serif; width: 180px; margin-left: 12px;"
    >
      Noticias
    </div>

    <!-- Container do carrossel-->
    <div class="relative overflow-hidden shadow-lg rounded-lg" style="height: 600px;">
      <transition-group name="slide-fade" tag="div" class="relative h-full">
        <div
          v-for="(news, index) in newsList"
          :key="news.title"
          v-show="index === currentIndex"
          class="absolute inset-0"
          style="will-change: transform, opacity;"
        >
          <img
            :src="news.image"
            :alt="news.title"
            class="w-full h-full object-cover"
            draggable="false"
          />
          <div
            class="absolute bottom-0 left-0 right-0 p-8"
            style="background-color: #f5e8d1; color: #3a3a3a; backdrop-filter: blur(6px);"
          >
            <h3 class="text-3xl font-semibold mb-4">{{ news.title }}</h3>
            <p class="text-lg mb-6">{{ news.summary }}</p>
            <a
              :href="news.link"
              class="inline-block bg-[#f2a532] hover:bg-[#d18c1f] text-white px-6 py-3 rounded font-semibold transition"
            >
              Saiba mais
            </a>
          </div>
        </div>
      </transition-group>

      <!-- Botões de navegação -->
      <button
        @click="prev"
        aria-label="Notícia anterior"
        class="absolute top-1/2 left-4 -translate-y-1/2 rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition"
        :style="{ backgroundColor: '#f2a532' }"
      >
        <svg
          class="w-8 h-8"
          fill="none"
          stroke="currentColor"
          stroke-width="3"
          viewBox="0 0 24 24"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M15 18l-6-6 6-6" stroke="#3a3a3a"></path>
        </svg>
      </button>
      <button
        @click="next"
        aria-label="Próxima notícia"
        class="absolute top-1/2 right-4 -translate-y-1/2 rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition"
        :style="{ backgroundColor: '#f2a532' }"
      >
        <svg
          class="w-8 h-8"
          fill="none"
          stroke="currentColor"
          stroke-width="3"
          viewBox="0 0 24 24"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M9 18l6-6-6-6" stroke="#3a3a3a"></path>
        </svg>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const newsList = ref([
  {
    title: 'Campanha de Adoção neste Sábado!',
    summary: 'Participe da nossa campanha e encontre seu novo melhor amigo.',
    image: '/images/news1.jpg',
    link: '/noticias/1',
  },
  {
    title: 'Novos Parceiros na Causa Animal',
    summary: 'Conheça os novos apoiadores do nosso projeto.',
    image: '/images/news2.jpg',
    link: '/noticias/2',
  },
  {
    title: 'Evento Educativo sobre Meio Ambiente',
    summary: 'Saiba como foi o evento voltado para crianças e famílias.',
    image: '/images/news3.jpg',
    link: '/noticias/3',
  },
])

const currentIndex = ref(0)

function prev() {
  currentIndex.value = (currentIndex.value - 1 + newsList.value.length) % newsList.value.length
}

function next() {
  currentIndex.value = (currentIndex.value + 1) % newsList.value.length
}
</script>

<style scoped>
.news-carousel {
  font-family: 'Nunito', sans-serif;
}

.news-title {
  margin-bottom: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: all 0.6s ease;
  position: absolute;
}

.slide-fade-enter-from {
  opacity: 0;
  transform: translateX(100%);
}
.slide-fade-enter-to {
  opacity: 1;
  transform: translateX(0%);
}

.slide-fade-leave-from {
  opacity: 1;
  transform: translateX(0%);
}
.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(-100%);
}
</style>
