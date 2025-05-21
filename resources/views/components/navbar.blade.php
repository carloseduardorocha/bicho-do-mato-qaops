<nav class="bg-green-700 text-white p-4">
  <div class="container mx-auto flex justify-between items-center">
    <a href="/" class="flex items-center gap-2">
      <img src="{{ Vite::asset('resources/images/icons/menu.png') }}" alt="Menu" class="h-6">
      <span class="font-semibold text-lg">Bicho do Mato</span>
    </a>
    <ul class="flex gap-4 text-sm">
      <li><a href="/como-ajudar" class="hover:underline">Como Ajudar</a></li>
      <li><a href="/depoimentos" class="hover:underline">Depoimentos</a></li>
      <li><a href="/noticias" class="hover:underline">Notícias</a></li>
      <li><a href="/parceiros" class="hover:underline">Parceiros</a></li>
      <li><a href="/institucional" class="hover:underline">Institucional</a></li>
      <li><a href="/adote" class="hover:underline font-semibold">Adote um Pet</a></li>
    </ul>
    <a href="mailto:contato@bichodomato.org.br">
      <img src="{{ Vite::asset('resources/images/icons/icone_email.png') }}" alt="Contato" class="h-6">
    </a>
  </div>
</nav>