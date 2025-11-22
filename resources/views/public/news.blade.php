@extends('layouts.app')

@section('title', 'Notícias - Bicho do Mato')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Nunito', sans-serif;
        overflow-x: hidden;
        position: relative;
        background-image: 
            linear-gradient(rgba(47, 82, 51, 0.75), rgba(47, 82, 51, 0.75)),
            url('<?= asset('images/background.jpg') ?>');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    /* Section Base */
    .section {
        padding: 60px 5%;
        position: relative;
    }

    /* Notícias Section */
    .noticias-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 80px;
    }

    .noticias-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Título Notícias */
    .noticias-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .noticias-title h1 {
        color: #fff;
        font-size: 3.5rem;
        margin: 0;
    }

    .noticias-title .nossas {
        font-weight: 900;
        font-style: normal;
    }

    .noticias-title .noticias {
        font-weight: 200;
        font-style: italic;
    }

    /* Grid de Notícias */
    .noticias-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        margin: 60px auto 60px;
        justify-content: center;
    }

    .noticia-card {
        background: rgba(47, 82, 51, 0.85);
        border-radius: 20px;
        flex: 0 0 380px;
        padding: 0;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }
    .noticia-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .noticia-image-wrapper {
        width: 100%;
        height: 350px;
        overflow: hidden;
    }

    .noticia-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .noticia-card:hover .noticia-image {
        transform: scale(1.05);
    }

    .noticia-content {
        padding: 30px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .noticia-titulo {
        color: #fff;
        font-size: 1.8rem;
        font-weight: 900;
        margin-bottom: 15px;
        line-height: 1.3;
    }

    .noticia-descricao {
        color: #f5e8d1;
        font-size: 1.2rem;
        line-height: 1.6;
        margin-bottom: 25px;
        font-weight: 600;
        flex: 1;
    }

    .noticia-btn {
        display: inline-block;
        background: #f3a632;
        color: #fff;
        padding: 12px 40px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 1.2rem;
        font-weight: 800;
        font-style: italic;
        text-transform: uppercase;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(243, 166, 50, 0.4);
        text-align: center;
        align-self: flex-start;
    }

    .noticia-btn:hover {
        background: #5c3a21;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(92, 58, 33, 0.5);
    }

    .linha-branca-responsiva {
        border: none;
        height: 1.5px;
        background-color: white;
        width: 650px;
        margin: 20px auto;
        max-width: calc(100% - 20px);
    }

    /* Paginação */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 60px;
        margin-bottom: 0;
    }

    .pagination {
        display: flex;
        gap: 10px;
        list-style: none;
        padding: 0;
        margin: 0;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination li {
        display: inline-block;
    }

    .pagination a,
    .pagination span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 50px;
        height: 50px;
        padding: 0 15px;
        background: #f5e8d1;
        color: #2f5233;
        border-radius: 10px;
        text-decoration: none;
        font-size: 1.1rem;
        font-weight: 800;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .pagination a:hover {
        background: #f3a632;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(243, 166, 50, 0.4);
    }

    .pagination .active span {
        background: #f3a632;
        color: #fff;
        box-shadow: 0 8px 20px rgba(243, 166, 50, 0.4);
    }

    .pagination .disabled span {
        background: rgba(245, 232, 209, 0.4);
        color: rgba(47, 82, 51, 0.4);
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Responsividade */
    @media (max-width: 1300px) {
        .noticias-grid {
            grid-template-columns: repeat(2, 1fr);
            justify-content: center;
        }
    }

    @media (max-width: 1000px) {
        .noticias-grid {
            grid-template-columns: 1fr;
            max-width: 700px;
            margin: 60px auto 60px;
            justify-content: center;
        }
    }

    @media (max-width: 910px) {
        .noticia-content {
            padding: 25px;
        }

        .noticia-titulo {
            font-size: 1.6rem;
        }

        .noticia-descricao {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .noticias-title h1 {
            font-size: 2rem;
        }

        .noticia-content {
            padding: 20px;
        }

        .noticia-titulo {
            font-size: 1.5rem;
        }

        .noticia-descricao {
            font-size: 1.0rem;
        }

        .noticia-btn {
            padding: 10px 30px;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 512px) {
        .noticia-titulo {
            font-size: 1.3rem;
        }

        .noticia-descricao {
            font-size: 0.95rem;
        }
    }

    @media (max-width: 480px) {

        .noticia-content {
            padding: 18px;
        }

        .noticia-titulo {
            font-size: 1.2rem;
        }

        .noticia-descricao {
            font-size: 0.9rem;
        }

        .noticia-btn {
            padding: 8px 25px;
            font-size: 1.0rem;
        }

        .pagination a,
        .pagination span {
            min-width: 45px;
            height: 45px;
            font-size: 1.0rem;
            padding: 0 12px;
        }
    }
</style>

<!-- Notícias Section -->
<section class="section noticias-section">
    <hr class="linha-branca-responsiva">
    
    <div class="noticias-container">
        <div class="noticias-title">
            <h1><span class="nossas">NOSSAS</span> <span class="noticias">NOTÍCIAS</span></h1>
        </div>

        <!-- Grid de Notícias -->
        <div class="noticias-grid">
            @foreach($news as $item)
                @php
                    // Pega a primeira imagem do JSON
                    $imgs  = !empty($item['images']) ? json_decode($item['images'], true) : [];
                    $image = $imgs[0];
                @endphp
                <div class="noticia-card">
                    <div class="noticia-image-wrapper">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $item->title }}" class="noticia-image">
                    </div>
                    <div class="noticia-content">
                        <h3 class="noticia-titulo">{{ $item->title }}</h3>
                        <p class="noticia-descricao">{{ Str::limit($item->description, 150) }}</p>
                        <a href="{{ route('public.show-news', $item->id) }}" class="noticia-btn">Ver Notícia</a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginação -->
         <div class="pagination-wrapper">
            <ul class="pagination">
                {{-- Previous --}}
                @if ($news->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $news->previousPageUrl() }}">&laquo;</a></li>
                @endif

                {{-- Números --}}
                @foreach ($news->getUrlRange(1, $news->lastPage()) as $page => $url)
                    @if ($page == $news->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($news->hasMorePages())
                    <li><a href="{{ $news->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        </div>
    </div>
</section>

@endsection