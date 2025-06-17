<template>
  <div class="w-full h-[240px] relative flex items-center"
    style="background-image: url('/images/header/bg-header.jpg'); background-size: cover; background-position: center;">
    <!-- Notificação fixa acima do nav, à direita -->
    <div class="hidden md:flex absolute top-3 right-8 h-[58px] w-[110px] bg-[#F9B233] rounded-[16px] items-center justify-center z-20 shadow-md gap-3">
      <button class="focus:outline-none">
        <img src="/images/icons/notification.png" alt="Notificações" class="w-[41px] h-[41px] object-contain" />
      </button>
      <button class="focus:outline-none">
        <img src="/images/icons/user_config.png" alt="Usuário" class="w-[38px] h-[38px] object-contain" />
      </button>
    </div>
    <div class="flex items-center justify-between w-full max-w-[1280px] mx-auto px-4 md:px-8">
      <a href="/" class="ml-[85px] mr-[50px]">
        <img src="/images/logo.png" alt="Logo" class="w-auto h-[214px] max-w-[187.36px]">
      </a>
      <nav class="w-[1085px] bg-[#2F5233] rounded-[28px] h-[58px] flex items-center px-4 shadow-md z-10 mr-[35px]">
        <ul class="flex flex-1 justify-between items-center gap-4 md:gap-8">
          <li>
            <a :href="'/'" :class="navClass('/')">Home</a>
          </li>
          <li>
            <a :href="'/como-ajudar'" :class="navClass('/como-ajudar')">Ajude</a>
          </li>
          <li>
            <a :href="'/institucional'" :class="navClass('/institucional')">Institucional</a>
          </li>
          <li>
            <a :href="'/noticias'" :class="navClass('/noticias')">Notícias</a>
          </li>
          <li>
            <a :href="'/depoimentos'" :class="navClass('/depoimentos')">Depoimentos</a>
          </li>
          <li>
            <a :href="'/parceiros'" :class="navClass('/parceiros')">Ver mais</a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script setup lang="ts">

const currentPath = window.location.pathname.replace(/\/$/, '');

function navClass(path: string) {
  // Remove barra final para comparar
  const normalized = path.replace(/\/$/, '');
  const isActive = currentPath === normalized || (normalized === '/' && currentPath === '');
  return [
    'italic text-white text-base md:text-lg px-2 py-1 rounded-[18px] transition-colors',
    isActive ? 'bg-[#40643e] font-bold' : '',
  ];
}
</script>
