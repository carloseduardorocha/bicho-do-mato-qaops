<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'ONG Bicho do Mato')</title>

    <!-- {{-- Vite --}} -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->

    {{-- Favicon padrão --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Favicon em SVG (recomendado) --}}
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Ícone para iPhone/iPad quando salvo na tela inicial --}}
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">

    {{-- Fonte Nunito --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
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
