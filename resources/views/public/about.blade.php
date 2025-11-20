@extends('layouts.app')

@section('title', 'Institucional - Bicho do Mato')

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

    /* Institucional Section */
    .institucional-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 0 !important;
    }

    .institucional-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Título Nossa História */
    .institucional-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .institucional-title h1 {
        color: #fff;
        font-size: 3.5rem;
        margin: 0;
    }

    .institucional-title .nossa {
        font-weight: 900;
        font-style: normal;
    }

    .institucional-title .historia {
        font-weight: 200;
        font-style: italic;
    }

    /* Container da Imagem Hero */
    .hero-container {
        position: relative;
        margin-bottom: 100px;
        display: flex;
        justify-content: center;
        z-index: 5;
    }

    .hero-image {
        width: 100%;
        max-width: 1300px;
        height: 800px;
        object-fit: cover;
        display: block;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    /* Título sobreposto */
    .main-title {
        position: absolute;
        bottom: -20px;
        left: 50%;
        transform: translateX(-50%);
        text-align: center;
        width: 100%;
        z-index: 10;
    }

    .main-title h2 {
        color: #f3a632;
        font-size: 3.5rem;
        font-weight: 900;
        text-transform: uppercase;
        line-height: 1;
        -webkit-text-stroke: 30px #2f5233;
        paint-order: stroke fill;
        margin: 0;
    }

    /* Conteúdo da História em Cards */
    .content-section {
        margin-top: 40px;
        margin-bottom: 60px;
    }

    .historia-row {
        display: grid;
        gap: 30px;
        margin-bottom: 30px;
    }

    .historia-row:last-child {
        margin-bottom: 0;
    }

    .historia-row-2 {
        grid-template-columns: repeat(2, 1fr);
    }

    .historia-row-3 {
        grid-template-columns: repeat(3, 1fr);
    }

    .historia-card {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 40px 35px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 220px;
    }

    .historia-card p {
        color: #2f5233;
        font-size: 1.5rem;
        line-height: 1.8;
        text-align: center;
        margin: 0;
        font-weight: 600;
    }

    /* Missão, Visão e Valores Section */
    .mvv-section {
        background: transparent;
        padding-top: 40px;
        padding-bottom: 80px;
    }

    .mvv-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    .mvv-wrapper {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 40px;
        margin: 0 auto;
        max-width: 1300px;
    }

    .mvv-card {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Ícone circular */
    .mvv-icon-wrapper {
        width: 210px;
        height: 210px;
        border-radius: 50%;
        background: #f3a632;
        margin: 0 auto 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .mvv-icon-wrapper i {
        font-size: 100px;
        color: #2f5233;
    }

    .mvv-titulo {
        color: #2f5233;
        font-size: 2.0rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .mvv-texto {
        color: #2f5233;
        font-size: 1.3rem;
        line-height: 1.6;
        font-weight: 600;
        text-align: center;
    }

    .linha-branca-responsiva {
        border: none;
        height: 1.5px;
        background-color: white;
        width: 650px;
        margin: 20px auto;
        max-width: calc(100% - 20px);
    }

    /* Responsividade */
    @media (max-width: 1000px) {
        .historia-row-2,
        .historia-row-3 {
            grid-template-columns: 1fr;
        }

        .mvv-wrapper {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    @media (max-width: 910px) {
        .main-title h2 {
            font-size: 2.8rem;
            line-height: 1.1;
        }

        .hero-image {
            height: 700px;
        }

        .historia-card {
            padding: 35px 30px;
            min-height: 200px;
        }

        .historia-card p {
            font-size: 1.3rem;
        }

        .mvv-wrapper {
            gap: 30px;
        }

        .mvv-card {
            padding: 35px 25px;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .institucional-title h1 {
            font-size: 2rem;
        }

        .main-title h2 {
            font-size: 2.5rem;
            -webkit-text-stroke: 25px #2f5233;
        }

        .hero-image {
            height: 500px;
        }

        .historia-card {
            padding: 30px 25px;
            min-height: 180px;
        }

        .historia-card p {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 626px) {
        .main-title h2 {
            font-size: 2rem;
        }
    }

    @media (max-width: 512px) {
        .main-title h2 {
            font-size: 1.8rem;
            -webkit-text-stroke: 18px #2f5233;
        }

        .historia-card {
            padding: 25px 20px;
            min-height: 160px;
        }

        .mvv-icon-wrapper {
            width: 180px;
            height: 180px;
        }

        .mvv-icon-wrapper i {
            font-size: 80px;
        }

        .mvv-titulo {
            font-size: 1.6rem;
        }

        .mvv-texto {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .main-title h2 {
            font-size: 1.7rem;
        }

        .hero-image {
            height: 400px;
        }

        .historia-card p {
            font-size: 1.0rem;
        }

        .mvv-icon-wrapper {
            width: 150px;
            height: 150px;
        }

        .mvv-icon-wrapper i {
            font-size: 70px;
        }
    }
</style>

<!-- Institucional Section -->
<section class="section institucional-section">
    <hr class="linha-branca-responsiva">
    
    <div class="institucional-container">
        <div class="institucional-title">
            <h1><span class="nossa">NOSSA</span> <span class="historia">HISTÓRIA</span></h1>
        </div>

        <!-- Hero Container -->
        <div class="hero-container">
            <img src="{{ asset('images/arara.jpg') }}" alt="Arara da ONG" class="hero-image">
            
            <div class="main-title">
                <h2>Como tudo começou...</h2>
            </div>
        </div>

        <!-- Conteúdo da História em Cards -->
        <div class="content-section">
            <!-- Primeira linha: 2 cards -->
            <div class="historia-row historia-row-2">
                <div class="historia-card">
                    <p>A ONG Bicho do Mato nasceu do amor pelos animais e da urgência em oferecer acolhimento a cães e gatos abandonados.</p>
                </div>
                <div class="historia-card">
                    <p>Desde sua fundação, atua no resgate, tratamento, castração e busca por lares responsáveis para animais em situação de risco.</p>
                </div>
            </div>

            <!-- Segunda linha: 3 cards -->
            <div class="historia-row historia-row-3">
                <div class="historia-card">
                    <p>Com o apoio de voluntários e doações, conseguimos transformar histórias de dor em finais felizes.</p>
                </div>
                <div class="historia-card">
                    <p>Nosso trabalho é movido pela empatia, compromisso e respeito à vida. Mais do que uma ONG, somos uma rede de cuidado e esperança.</p>
                </div>
                <div class="historia-card">
                    <p>Cada ajuda recebida é um passo a mais na construção de um mundo mais justo para os animais.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<hr class="linha-branca-responsiva">
<!-- Missão, Visão e Valores -->
<section class="section mvv-section">
    <div class="mvv-container">
        <div class="mvv-wrapper">
            <!-- Missão -->
            <div class="mvv-card">
                <div class="mvv-icon-wrapper">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="mvv-titulo">Missão</h3>
                <p class="mvv-texto">
                    Resgatar, cuidar e promover a adoção responsável de animais em situação de abandono, oferecendo amor, tratamento e dignidade.
                </p>
            </div>

            <!-- Visão -->
            <div class="mvv-card">
                <div class="mvv-icon-wrapper">
                    <i class="fas fa-eye"></i>
                </div>
                <h3 class="mvv-titulo">Visão</h3>
                <p class="mvv-texto">
                    Ser referência em proteção animal, ampliando o impacto social e construindo uma comunidade mais consciente e compassiva.
                </p>
            </div>

            <!-- Valores -->
            <div class="mvv-card">
                <div class="mvv-icon-wrapper">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="mvv-titulo">Valores</h3>
                <p class="mvv-texto">
                    Amor e respeito pelos animais;<br/>
                    Transparência e responsabilidade;<br/>
                    Trabalho em equipe e voluntariado;<br/>
                    Educação e conscientização;<br/>
                    Adoção responsável e castração preventiva.<br/>
                </p>
            </div>
        </div>
    </div>
</section>

@endsection