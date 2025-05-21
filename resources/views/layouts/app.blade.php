<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'ONG Bicho do Mato')</title>

  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Ícone favicon (opcional) --}}
  <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="bg-gray-50 text-gray-800 font-sans leading-normal">

  {{-- Menu --}}
  <x-navbar />

  {{-- Conteúdo dinâmico das páginas --}}
  <main class="min-h-[80vh]">
    @yield('content')
  </main>

  {{-- Rodapé --}}
  <x-footer />

</body>
</html>