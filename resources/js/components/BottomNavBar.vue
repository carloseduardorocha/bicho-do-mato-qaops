<template>
  <div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-orange-300 border-t border-gray-200">
    teste
  </div>
</template>

<script setup lang="ts">
function navigate(url: string) {
  window.location.href = url;
}
</script>

<!-- <style scoped>
/* nav {
  /* Mobile first: barra fixa no rodapé */
}
@media (min-width: 768px) {
  nav {
    position: static;
    border-radius: 0;
    background: transparent;
    padding-top: 0;
    padding-bottom: 0;
  }
} */
</style> -->