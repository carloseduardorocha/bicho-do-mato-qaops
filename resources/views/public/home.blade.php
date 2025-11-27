@extends('layouts.app')

@section('title', 'Início - Bicho do Mato')

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

    /* Banner Hero */
    .hero-banner {
        position: relative;
        width: 100%;
        overflow: hidden;
        margin-bottom: 0;
        background-color: #04512d;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .hero-banner-inner {
        max-width: 1350px;
    }

    .hero-banner img {
        width: 100%;
        height: auto;
    }

    /* Section Base */
    .section {
        padding: 60px 5%;
        position: relative;
    }

    /* Section Headers */
    .section-header {
        background: #f3a632;
        padding: 12px 45px;
        border-radius: 20px 20px 0 0;
        display: inline-block;
        margin-bottom: 0;
        margin-left: 5%;
        min-width: 100px;
    }

    .section-header h2 {
        color: #fff;
        font-size: 1.6rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-style: italic;
        margin: 0;
    }

    /* Notícias Section */
    .noticias-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 20px;
    }

    .carousel-container {
        position: relative;
        max-width: 1720px;
        margin: 0 auto;
        padding-bottom: 40px;
    }

    .carousel-wrapper {
        overflow: hidden;
        border-radius: 20px;
        background: #fff;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    }

    .carousel-slides {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .carousel-slide {
        min-width: 100%;
        display: flex;
        flex-direction: column;
    }

    .slide-image {
        width: 100%;
        height: 550px;
        object-fit: cover;
    }

    .slide-content {
        min-height: 180px;
        padding: 35px 40px;
        background: #f5e8d1;
        position: relative;
    }

    .slide-badge {
        position: absolute;
        top: -25px;
        left: 40px;
        background: #2f5233;
        color: #f3a632;
        padding: 10px 30px;
        border-radius: 0 50px 50px 0;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        font-style: italic;
        letter-spacing: 1px;
    }

    .slide-title {
        color: #2f5233;
        font-size: 1.6rem;
        font-weight: 800;
        margin-bottom: 15px;
        margin-top: 20px;
        text-transform: uppercase;
        line-height: 1.3;
    }

    .slide-text {
        color: #2f5233;
        font-size: 20px;
        font-weight: 600;
        line-height: 1.3;
    }

    .carousel-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        left: 0;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 10;
        padding: 10px;
    }

    .carousel-btn {
        pointer-events: all;
        background: #f3a632;
        border: none;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        color: #fff;
        font-size: 1.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .carousel-btn:hover {
        background: #5c3a21;
        transform: scale(1.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    /* Depoimentos Section */
    .depoimentos-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 80px;
    }
    
    .depoimentos-container {
        max-width: 1720px;
        margin: 0 auto;
    }

    .depoimentos-wrapper {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    }

    .depoimentos-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
        position: relative;
    }

    .depoimentos-grid::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 10%;
        bottom: 10%;
        width: 2px;
        background: #2f5233;
        transform: translateX(-50%);
    }

    .depoimento-card {
        padding: 20px 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .depoimento-avatar {
        width: 312px;
        height: 312px;
        border-radius: 50%;
        margin: 0 auto 20px;
        overflow: hidden;
        border: 6px solid #f3a632;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
    }

    .depoimento-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .depoimento-nome {
        color: #2f5233;
        font-size: 1.5rem;
        font-weight: 900;
        margin-bottom: 10px;
    }

    .depoimento-texto {
        color: #2f5233;
        font-size: 1.5rem;
        line-height: 1.6;
        text-align: center;
    }

    .ver-mais-btn {
        display: block;
        margin: 0 auto 0;
        background: #f3a632;
        color: #fff;
        padding: 15px 60px;
        border-radius: 50px;
        border: none;
        font-size: 1.3rem;
        font-weight: 800;
        text-transform: uppercase;
        font-style: italic;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(243, 166, 50, 0.4);
        letter-spacing: 1px;
    }

    .ver-mais-btn:hover {
        background: #5c3a21;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(92, 58, 33, 0.5);
    }

    /* Parceiros Section */
    .parceiros-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .parceiros-container {
        max-width: 1720px;
        margin: 0 auto;
    }

    .parceiros-wrapper {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 60px 0 30px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        position: relative;
    }

    .parceiros-carousel-container {
        position: relative;
        max-width: 100%;
        margin: 0;
        padding: 0 80px;
    }

    .parceiros-carousel-wrapper {
        overflow: hidden;
        margin-bottom: 40px;
    }

    .parceiros-grid {
        display: flex;
        transition: transform 0.5s ease-in-out;
        gap: 40px;
    }

    .parceiro-card {
        min-width: calc(33.333% - 27px);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex-shrink: 0;
    }

    .parceiros-controls {
        position: absolute;
        top: 50%;
        width: 100%;
        left: 0;
        display: flex;
        justify-content: space-between;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 10;
        padding: 0 10px;
    }

    .parceiros-btn {
        pointer-events: all;
        background: #f3a632;
        border: none;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        color: #fff;
        font-size: 1.8rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .parceiros-btn:hover {
        background: #5c3a21;
        transform: scale(1.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.4);
    }

    .parceiro-logo {
        max-width: 312px;
        max-height: 312px;
        margin: 0 auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .parceiro-logo img {
        width: 100%;
        height: 100%;
    }

    .parceiro-nome {
        color: #2f5233;
        font-size: 1.4rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .parceiro-cnpj {
        color: #5c3a21;
        font-size: 0.95rem;
        font-weight: 600;
    }

    /* Redes Sociais Section */
    .redes-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 80px;
    }

    .redes-container {
        max-width: 1720px;
        margin: 0 auto;
    }

    .redes-wrapper {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    }

    .redes-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
    }

    .rede-card {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .rede-icon-wrapper {
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: #f3a632;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .rede-icon-wrapper img {
        width: 80%;
        height: 80%;
        object-fit: contain;
    }

    .rede-icon-wrapper svg {
        width: 80%;
        height: 80%;
        object-fit: contain;
        color: #5c3a21;
    }

    .rede-nome {
        color: #2f5233;
        font-size: 2.0rem;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .rede-handle {
        color: #5c3a21;
        font-size: 1.2rem;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .seguir-btn {
        background: #2f5233;
        color: #fff;
        padding: 12px 80px;
        border-radius: 50px;
        border: none;
        font-size: 1.5rem;
        font-weight: 800;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    .seguir-btn:hover {
        background: #5c3a21;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        color: #fff;
    }

    /* Onde Estamos Section */
    .localizacao-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 60px;
    }

    .localizacao-content {
        max-width: 1720px;
        margin: 0 auto;
    }

    .mapa-wrapper {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
    }

    .mapa-wrapper iframe {
        width: 100%;
        height: 650px;
        border: none;
        display: block;
    }

    @media (max-width: 1920px) {
      .carousel-container {
          max-width: 1300px;
      }
      .depoimentos-container {
          max-width: 1300px;
      }
      
      .parceiros-container {
          max-width: 1300px;
      }
      
      .redes-container {
          max-width: 1300px;
      }
      
      .localizacao-content {
          max-width: 1300px;
      }
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .carousel-controls {
            width: calc(100% + 80px);
            left: -40px;
        }

        .carousel-btn {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .parceiros-carousel-container {
            padding: 0 60px;
        }

        .parceiros-btn {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .parceiro-card {
            min-width: calc(50% - 20px);
        }

        .depoimentos-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .depoimentos-grid::after {
            display: none;
        }

        
    }

    @media (max-width: 920px) {
        .parceiro-logo {
            max-width: 260px;
            max-height: 260px;
        }
        .redes-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .slide-badge {
            left: 0;
            position: relative !important;
            margin: 0 auto 0 auto !important;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 0;
            white-space: normal !important;
            width: 100%;
            text-align: center;
        }

        .slide-text {
            margin-top: 0 !important;
        }
    }
    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .section-header {
            padding: 10px 35px;
        }

        .section-header h2 {
            font-size: 1.3rem;
        }

        .slide-image {
            height: 280px;
        }

        .slide-badge {
            font-size: 0.9rem;
        }

        .slide-title {
            font-size: 1.3rem;
        }

        .slide-text {
            font-size: 0.95rem;
        }

        .depoimentos-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .depoimentos-grid::after {
            display: none;
        }

        .depoimentos-wrapper,
        .redes-wrapper {
            padding: 35px;
        }

        .parceiros-carousel-container {
            padding: 0 50px;
        }

        .parceiros-wrapper {
            padding: 35px 0;
        }

        .parceiros-btn {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }

        .parceiro-card {
            min-width: 100%;
        }

        .parceiro-logo {
            max-width: 240px;
            max-height: 240px;
        }

        .redes-grid {
            grid-template-columns: 1fr;
        }

        .carousel-controls {
            width: calc(100% + 40px);
            left: -20px;
        }

        .carousel-btn {
            width: 50px;
            height: 50px;
            font-size: 1.3rem;
        }
    }
    @media (max-width: 524px) {
        .depoimento-avatar {
            width: 240px;
            height: 240px;
        }
    }

    @media (max-width: 480px) {
        .section-header {
            padding: 8px 25px;
        }

        .section-header h2 {
            font-size: 1.1rem;
        }

        .depoimentos-wrapper,
        .redes-wrapper {
            padding: 25px;
        }

        .parceiros-wrapper {
            padding: 25px 0;
        }

        .depoimento-avatar {
            width: 180px;
            height: 180px;
        }

        .parceiros-carousel-container {
            padding: 0 20px;
        }

        .parceiro-logo,
        .rede-icon-wrapper {
            width: 150px;
            height: 150px;
        }

        .ver-mais-btn {
            font-size: 1.1rem;
            padding: 12px 50px;
        }
    }
</style>

<!-- Banner Hero -->
<section class="hero-banner">
    <div class="hero-banner-inner">
        <img src="{{ asset('images/banner-fauna.png') }}" alt="Ajude a Cuidar da Nossa Fauna - Bicho do Mato">
    </div>
</section>

<!-- Notícias -->
<section class="section noticias-section">   
    <div class="carousel-container">
        <div class="section-header">
            <h2>Notícias</h2>
        </div>
        <div class="carousel-wrapper">
            <div class="carousel-slides" id="carouselSlides">
                @foreach ($news as $item)
                    @php
                        // Pega a primeira imagem do JSON
                        $imgs  = !empty($item['images']) ? json_decode($item['images'], true) : [];
                        $image = $imgs[0];
                    @endphp

                    <div class="carousel-slide">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $item['title'] }}" class="slide-image">
                        <div class="slide-content">
                            <div class="slide-badge">{{ strtoupper($item['title']) }}</div>
                            <p class="slide-text">
                                {{ Str::limit($item['description'], 300) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="carousel-controls">
            <button class="carousel-btn prev" onclick="moveSlide(-1)" aria-label="Anterior">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-btn next" onclick="moveSlide(1)" aria-label="Próximo">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
    <button class="ver-mais-btn" onclick="window.location.href='<?= route('public.news') ?>'">
        Ver Todas as Noticias
    </button>
</section>

<!-- Depoimentos -->
<section class="section depoimentos-section">
    <div class="depoimentos-container">
        <div class="section-header">
            <h2>Depoimentos</h2>
        </div>
        <div class="depoimentos-wrapper">
            <div class="depoimentos-grid">

                @foreach ($testimonials as $item)
                    <div class="depoimento-card">
                        <div class="depoimento-avatar">
                            <img src="{{ asset('storage/' . ($item['image'])) }}" alt="{{ $item['name'] }}">
                        </div>
                        <h3 class="depoimento-nome">{{ $item['name'] }}</h3>
                        <p class="depoimento-texto">{{ Str::limit($item['description'], 100) }}</p>
                    </div>
                @endforeach

            </div>

            <button class="ver-mais-btn" onclick="window.location.href='<?= route('public.testimonials') ?>'">
                Ver Mais
            </button>
        </div>
    </div>
</section>

<!-- Nossos Parceiros -->
<section class="section parceiros-section">   
    <div class="parceiros-container">
        <div class="section-header">
            <h2>Nossos Parceiros</h2>
        </div>
        <div class="parceiros-wrapper">
            <div class="parceiros-carousel-container">
                <div class="parceiros-carousel-wrapper">
                    <div class="parceiros-grid" id="parceirosSlides">
                        @foreach($partners as $partner)
                            <div class="parceiro-card">
                                <div class="parceiro-logo">
                                    <img src="{{ asset('storage/' . ($partner['image'])) }}" alt="{{ $partner['name'] }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="ver-mais-btn" onclick="window.location.href='<?= route('public.partners') ?>'">
                    Ver Mais
                </button>
                <div class="parceiros-controls">
                    <button class="parceiros-btn prev" onclick="moveParceiros(-1)" aria-label="Anterior">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="parceiros-btn next" onclick="moveParceiros(1)" aria-label="Próximo">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Redes Sociais -->
<section class="section redes-section">
    <div class="redes-container">
        <div class="section-header">
            <h2>Redes Sociais</h2>
        </div>
        <div class="redes-wrapper">
            <div class="redes-grid">
                <!-- Instagram -->
                <div class="rede-card">
                    <h3 class="rede-nome">Instagram</h3>
                    <div class="rede-icon-wrapper">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram-icon lucide-instagram"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </div>
                    <p class="rede-handle">@ongbichodomato</p>
                    <a href="https://www.instagram.com/ongbichodomato" target="_blank" class="seguir-btn">Seguir</a>
                </div>
                
                <!-- Facebook -->
                <div class="rede-card">
                    <h3 class="rede-nome">Facebook</h3>
                    <div class="rede-icon-wrapper">
                        <svg viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#5c3a21" stroke-width="1.704"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M22 12C22 6.47714 17.5229 1.99999 12 1.99999C6.47715 1.99999 2 6.47714 2 12C2 16.9913 5.65686 21.1283 10.4375 21.8785V14.8906H7.89844V12H10.4375V9.79687C10.4375 7.29062 11.9304 5.90624 14.2146 5.90624C15.3087 5.90624 16.4531 6.10155 16.4531 6.10155V8.56249H15.1921C13.9499 8.56249 13.5625 9.33333 13.5625 10.1242V12H16.3359L15.8926 14.8906H13.5625V21.8785C18.3431 21.1283 22 16.9913 22 12Z" stroke="#5c3a21" stroke-linejoin="round"></path> </g></svg>
                    </div>
                    <p class="rede-handle">Luiz Carlos Rodrigues (Bug)</p>
                    <a href="https://www.facebook.com/bug.luiz.carlos.rodrigues" target="_blank" class="seguir-btn">Acessar</a>
                </div>
                
                <!-- WhatsApp -->
                <div class="rede-card">
                    <h3 class="rede-nome">WhatsApp</h3>
                    <div class="rede-icon-wrapper">
                        <svg fill="#5c3a21" width="137px" height="137px" viewBox="0 0 32.00 32.00" version="1.1" xmlns="http://www.w3.org/2000/svg" stroke="#5c3a21" stroke-width="0.00032"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>whatsapp</title> <path d="M26.576 5.363c-2.69-2.69-6.406-4.354-10.511-4.354-8.209 0-14.865 6.655-14.865 14.865 0 2.732 0.737 5.291 2.022 7.491l-0.038-0.070-2.109 7.702 7.879-2.067c2.051 1.139 4.498 1.809 7.102 1.809h0.006c8.209-0.003 14.862-6.659 14.862-14.868 0-4.103-1.662-7.817-4.349-10.507l0 0zM16.062 28.228h-0.005c-0 0-0.001 0-0.001 0-2.319 0-4.489-0.64-6.342-1.753l0.056 0.031-0.451-0.267-4.675 1.227 1.247-4.559-0.294-0.467c-1.185-1.862-1.889-4.131-1.889-6.565 0-6.822 5.531-12.353 12.353-12.353s12.353 5.531 12.353 12.353c0 6.822-5.53 12.353-12.353 12.353h-0zM22.838 18.977c-0.371-0.186-2.197-1.083-2.537-1.208-0.341-0.124-0.589-0.185-0.837 0.187-0.246 0.371-0.958 1.207-1.175 1.455-0.216 0.249-0.434 0.279-0.805 0.094-1.15-0.466-2.138-1.087-2.997-1.852l0.010 0.009c-0.799-0.74-1.484-1.587-2.037-2.521l-0.028-0.052c-0.216-0.371-0.023-0.572 0.162-0.757 0.167-0.166 0.372-0.434 0.557-0.65 0.146-0.179 0.271-0.384 0.366-0.604l0.006-0.017c0.043-0.087 0.068-0.188 0.068-0.296 0-0.131-0.037-0.253-0.101-0.357l0.002 0.003c-0.094-0.186-0.836-2.014-1.145-2.758-0.302-0.724-0.609-0.625-0.836-0.637-0.216-0.010-0.464-0.012-0.712-0.012-0.395 0.010-0.746 0.188-0.988 0.463l-0.001 0.002c-0.802 0.761-1.3 1.834-1.3 3.023 0 0.026 0 0.053 0.001 0.079l-0-0.004c0.131 1.467 0.681 2.784 1.527 3.857l-0.012-0.015c1.604 2.379 3.742 4.282 6.251 5.564l0.094 0.043c0.548 0.248 1.25 0.513 1.968 0.74l0.149 0.041c0.442 0.14 0.951 0.221 1.479 0.221 0.303 0 0.601-0.027 0.889-0.078l-0.031 0.004c1.069-0.223 1.956-0.868 2.497-1.749l0.009-0.017c0.165-0.366 0.261-0.793 0.261-1.242 0-0.185-0.016-0.366-0.047-0.542l0.003 0.019c-0.092-0.155-0.34-0.247-0.712-0.434z"></path> </g></svg>
                    </div>
                    <p class="rede-handle">(55) 9 9621-9405</p>
                    <a href="https://wa.me/555596219405?text=Ol%C3%A1%21%20Acessei%20o%20site%20da%20ONG%20Bicho%20do%20Mato%20e%20gostaria%20de%20receber%20mais%20informa%C3%A7%C3%B5es%20sobre%20a%20institui%C3%A7%C3%A3o%20e%20como%20posso%20ajudar.%20Obrigado%21" target="_blank" class="seguir-btn">Contato</a>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // Carousel de Notícias
    let currentSlide = 0;
    const slides = document.querySelectorAll('.carousel-slide');
    const totalSlides = slides.length;

    function showSlide(index) {
        if (index >= totalSlides) {
            currentSlide = 0;
        } else if (index < 0) {
            currentSlide = totalSlides - 1;
        } else {
            currentSlide = index;
        }
        
        const slidesContainer = document.getElementById('carouselSlides');
        slidesContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function moveSlide(direction) {
        showSlide(currentSlide + direction);
    }

    // Auto-play carousel de notícias
    setInterval(() => {
        moveSlide(1);
    }, 6000);

    // Initialize notícias
    showSlide(0);

    // Carousel de Parceiros com Loop Infinito
    let currentParceiro = 0;
    const parceiros = document.querySelectorAll('.parceiro-card');
    const totalParceiros = parceiros.length;
    let parceirosVisiveis = 3; // Padrão: 3 visíveis

    function updateParceirosVisiveis() {
        if (window.innerWidth <= 768) {
            parceirosVisiveis = 1;
        } else if (window.innerWidth <= 1024) {
            parceirosVisiveis = 2;
        } else {
            parceirosVisiveis = 3;
        }
    }

    function showParceiros() {
        updateParceirosVisiveis();

        const parceirosContainer = document.getElementById('parceirosSlides');
        const cardWidth = parceiros[0].offsetWidth;
        const gap = 40;

        // Se o total de parceiros for menor que os visíveis, centraliza
        if (totalParceiros <= parceirosVisiveis) {
            const totalWidth = totalParceiros * cardWidth + (totalParceiros - 1) * gap;
            const containerWidth = parceirosContainer.offsetWidth;
            const offset = (containerWidth - totalWidth) / 2;
            parceirosContainer.style.transform = `translateX(${offset}px)`;
            return;
        }

        // Se houver apenas 1 parceiro visível (em telas pequenas), centraliza
        if (parceirosVisiveis === 1) {
            const containerWidth = parceirosContainer.offsetWidth;
            const offset = (cardWidth / 2 - containerWidth / 2) * -1; // centraliza
            parceirosContainer.style.transform = `translateX(${offset}px)`;
            return;
        }

        // Loop normal
        const offset = currentParceiro * (cardWidth + gap);
        parceirosContainer.style.transform = `translateX(-${offset}px)`;
    }

    function moveParceiros(direction) {
        currentParceiro += direction;
        
        // Loop infinito - volta pro início ou pro final
        if (currentParceiro < 0) {
            currentParceiro = totalParceiros - parceirosVisiveis;
        } else if (currentParceiro > totalParceiros - parceirosVisiveis) {
            currentParceiro = 0;
        }
        
        showParceiros();
    }

    // Initialize parceiros
    window.addEventListener('load', () => {
        showParceiros();
    });

    // Atualiza ao redimensionar a janela
    window.addEventListener('resize', () => {
        currentParceiro = 0; // Reset ao redimensionar
        showParceiros();
    });
</script>
@endsection