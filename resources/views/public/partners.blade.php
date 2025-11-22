@extends('layouts.app')

@section('title', 'Parceiros - Bicho do Mato')

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

    /* Parceiros Section */
    .parceiros-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 0;
    }

    .parceiros-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Título Parceiros */
    .parceiros-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .parceiros-title h1 {
        color: #fff;
        font-size: 3.5rem;
        margin: 0;
    }

    .parceiros-title .nossos {
        font-weight: 900;
        font-style: normal;
    }

    .parceiros-title .parceiros {
        font-weight: 200;
        font-style: italic;
    }

    /* Container da Imagem e Título */
    .hero-container {
        position: relative;
        margin-bottom: 100px;
        display: flex;
        justify-content: center;
        z-index: 5;
    }

    /* Imagem do Cachorro */
    .hero-image {
        width: 100%;
        max-width: 1300px;
        height: 800px;
        object-fit: cover;
        display: block;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    /* Título Principal com Contorno - Sobrepõe a Imagem */
    .main-title {
        position: absolute;
        bottom: -70px;
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
        padding: 0 20px;
    }

    /* Grid de Parceiros */
    .parceiros-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 40px;
        margin-bottom: 60px;
    }

    .parceiro-card {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 312px;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .parceiro-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
    }

    .parceiro-logo {
        max-width: 100%;
        max-height: 212px;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    /* Botão Seja um Parceiro */
    .parceiro-btn-wrapper {
        text-align: center;
        margin: 60px 0 80px;
        position: relative;
        z-index: 10;
    }

    .parceiro-btn {
        display: inline-flex;
        align-items: center;
        gap: 15px;
        background: #f3a632;
        color: #fff;
        padding: 5px 40px;
        border-radius: 20px;
        border: none;
        font-size: 3rem;
        font-weight: 100;
        text-transform: uppercase;
        font-style: italic;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(243, 166, 50, 0.4);
        letter-spacing: 1px;
        text-decoration: none;
    }

    .parceiro-btn strong {
        font-weight: 900;
    }

    .parceiro-btn:hover {
        background: #5c3a21;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(92, 58, 33, 0.5);
    }

    .parceiro-btn i {
        font-size: 3rem;
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
    @media (max-width: 1300px) {
        .parceiros-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 1000px) {
        .parceiros-grid {
            grid-template-columns: 1fr;
            max-width: 600px;
            margin: 0 auto 60px;
        }
    }

    @media (max-width: 910px) {
        .main-title h2 {
            font-size: 2.5rem;
            line-height: 1.2;
            -webkit-text-stroke: 25px #2f5233;
        }

        .hero-image {
            height: 700px;
        }

        .parceiro-btn {
            font-size: 2rem;
            padding: 5px 35px;
            border-radius: 15px;
        }

        .parceiro-btn i {
            font-size: 2rem;
        }

        .parceiro-btn-wrapper {
            margin: -25px 0 60px;
        }

        .parceiro-card {
            padding: 40px;
            min-height: 280px;
        }

        .parceiro-logo {
            max-height: 180px;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .parceiros-title h1 {
            font-size: 2rem;
        }

        .main-title h2 {
            font-size: 2.2rem;
            line-height: 1.1;
            -webkit-text-stroke: 20px #2f5233;
        }

        .hero-image {
            height: 500px;
        }

        .parceiro-btn {
            font-size: 2rem;
            padding: 5px 35px;
            border-radius: 15px;
        }

        .parceiro-btn i {
            font-size: 2rem;
        }

        .parceiro-btn-wrapper {
            margin: -25px 0 30px;
        }

        .parceiro-card {
            padding: 35px;
            min-height: 250px;
        }

        .parceiro-logo {
            max-height: 170px;
        }
    }

    @media (max-width: 626px) {
        .main-title h2 {
            font-size: 1.8rem;
        }

        .parceiro-btn {
            font-size: 1.8rem;
            padding: 5px 35px;
            border-radius: 15px;
        }

        .parceiro-btn i {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 512px) {
        .main-title h2 {
            font-size: 1.5rem;
            line-height: 1.3;
            -webkit-text-stroke: 18px #2f5233;
        }
        .parceiro-btn-wrapper {
            margin: -25px 0 30px;
        }

        .parceiro-btn {
            font-size: 1.4rem;
            padding: 3px 35px;
        }

        .parceiro-btn i {
            font-size: 1.4rem;
        }

        .parceiro-card {
            padding: 30px;
            min-height: 220px;
        }

        .parceiro-logo {
            max-height: 150px;
        }
    }

    @media (max-width: 480px) {
        .main-title h2 {
            font-size: 1.2rem;
            -webkit-text-stroke: 18px #2f5233;
        }

        .hero-image {
            height: 400px;
        }

        .parceiro-btn {
            font-size: 1.2rem;
            padding: 3px 30px;
        }

        .parceiro-btn i {
            font-size: 1.2rem;
        }

        .parceiro-card {
            padding: 25px;
            min-height: 200px;
        }

        .parceiro-logo {
            max-height: 140px;
        }
        .parceiro-btn-wrapper {
            margin: -25px 0 10px;
        }
    }
</style>

<!-- Parceiros Section -->
<section class="section parceiros-section">
    <hr class="linha-branca-responsiva">
    
    <div class="parceiros-container">
        <div class="parceiros-title">
            <h1><span class="nossos">NOSSOS</span> <span class="parceiros">PARCEIROS</span></h1>
        </div>

        <!-- Container Imagem + Título Sobreposto -->
        <div class="hero-container">
            <img src="{{ asset('images/parceiro.jpg') }}" alt="Voluntária com cachorro" class="hero-image">
            
            <div class="main-title">
                <h2>O NOSSO AGRADECIMENTO<br>A CADA UM QUE ACREDITA<br>NESSA CAUSA!</h2>
            </div>
        </div>

        <!-- Grid de Parceiros -->
        <div class="parceiros-grid">
            @foreach($partners as $partner)
                <a href="{{ $partner['link'] }}" class="parceiro-card" target="_blank">
                    <img src="{{ asset('storage/' . $partner['image']) }}" alt="{{ $partner['name'] }}" class="parceiro-logo">
                </a>
            @endforeach
        </div>

        <!-- Botão Seja um Parceiro -->
        <div class="parceiro-btn-wrapper">
            <a href="https://wa.me/555596219405?text=Ol%C3%A1!%20Gostaria%20de%20me%20tornar%20parceiro%20da%20ONG.%20Pode%20me%20passar%20mais%20informa%C3%A7%C3%B5es,%20por%20favor%3F" target="_blank" class="parceiro-btn">
                <span>Seja um <strong>Parceiro</strong></span>
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>
</section>

@endsection