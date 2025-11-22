@extends('layouts.app')

@section('title', 'Ajude - Bicho do Mato')

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

    /* Como Ajudar Section */
    .ajude-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 80px;
    }

    .ajude-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Título Como Ajudar */
    .ajude-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .ajude-title h1 {
        color: #fff;
        font-size: 3.5rem;
        margin: 0;
    }

    .ajude-title .como {
        font-weight: 900;
        font-style: normal;
    }

    .ajude-title .ajudar {
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

    /* Imagem do Cachorro - LARGA E MENOS ALTA */
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
        bottom: -30px;
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

    /* Seção de Conteúdo Intercalado */
    .content-section {
        margin-top: 40px;
    }

    /* Título no fundo verde (sem card) - estilo "Entre em contato conosco" */
    .section-title-verde {
        text-align: center;
        margin: 50px 0 30px;
    }

    .section-title-verde h3 {
        color: #fff;
        font-size: 3rem;
        font-weight: 800;
        line-height: 1.4;
    }

    .section-title-verde .em {
        font-style: italic;
        font-weight: 300;
    }

    .section-title-verde .destaque {
        font-weight: 900;
        font-style: normal;
    }

    /* Card bege para conteúdo */
    .content-card {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 50px 60px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        margin-bottom: 40px;
    }

    .content-card p {
        color: #2f5233;
        font-size: 1.8rem;
        line-height: 1.8;
        text-align: center;
        margin: 0;
    }

    /* Lista dentro do card */
    .ajude-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .ajude-list li {
        color: #2f5233;
        font-size: 1.8rem;
        line-height: 1.8;
        margin-bottom: 20px;
        padding-left: 30px;
        position: relative;
    }

    .ajude-list li::before {
        content: '•';
        color: #f3a632;
        font-weight: 900;
        font-size: 1.5rem;
        position: absolute;
        left: 0;
    }

    .ajude-list strong {
        color: #2f5233;
        font-weight: 800;
    }

    /* Imagem de Voluntários */
    .volunteers-image-wrapper {
        position: relative;
        margin: 40px auto;
        padding: 40px;
        text-align: center;
        max-width: 1300px;
    }

    .volunteers-image {
        width: 100%;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        z-index: 0;
    }

    /* Botão Adote Agora */
    .adote-btn-wrapper {
        text-align: center;
        margin: -120px 0 50px;
        position: relative;
        z-index: 10;
    }

    .adote-btn {
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

    .adote-btn strong {
        font-weight: 900;
    }

    .adote-btn:hover {
        background: #5c3a21;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(92, 58, 33, 0.5);
    }

    .adote-btn i {
        font-size: 3rem;
    }

    /* Seção de Doação */
    .doacao-section {
        background: transparent;
        padding-top: 0 !important;
        padding-bottom: 80px;
    }

    .doacao-container {
        max-width: 630px;
        margin: 0 auto;
    }

    .doacao-wrapper {
        background: #f3a632;
        border-radius: 20px;
        padding: 30px 30px 50px 30px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        text-align: center;
    }

    .doacao-title {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 900;
        text-transform: uppercase;
        margin-bottom: 30px;
    }

    .doacao-title .faca {
        font-weight: 900;
        font-style: normal;
    }

    .doacao-title .sua {
        font-weight: 300;
        font-style: italic;
    }

    .doacao-title .doacao {
        font-weight: 900;
        font-style: normal;
    }

    .qrcode-wrapper {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 40px;
        max-width: 500px;
        margin: 0 auto;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }

    .pix-label {
        color: #2f5233;
        font-size: 1.5rem;
        font-weight: 800;
        margin-bottom: 20px;
        text-transform: uppercase;
    }

    .pix-sub-label {
        color: #2f5233;
        font-size: 1rem;
        font-weight: 800;
        margin-bottom: 0;
        margin-top: 0;
        text-transform: uppercase;
    }

    .qrcode-image {
        width: 100%;
        max-width: 300px;
        margin: 0 auto 25px;
        display: block;
    }

    .doacao-description {
        color: #2f5233;
        font-size: 1.3rem;
        line-height: 1.6;
        font-weight: 600;
    }

    .linha-branca-responsiva {
        border: none;
        height: 1.5px;
        background-color: white;
        width: 650px;
        margin: 20px auto;
        max-width: calc(100% - 20px);
    }

    .linha-verde-responsiva {
        border: none;
        height: 1.5px;
        background-color: #2f5233;
        margin: 20px auto;
        max-width: calc(100% - 20px);
    }

    /* Responsividade */
    @media (max-width: 910px) {
        .main-title h2 {
            font-size: 2.8rem;
            line-height: 1.1;
        }

        .hero-image {
            max-width: 100%;
            height: 700px;
        }

        .adote-btn {
            font-size: 2rem;
            padding: 5px 35px;
            border-radius: 15px;
        }

        .adote-btn i {
            font-size: 2rem;
        }

        .section-title-verde h3 {
            font-size: 2.5rem;
        }

        .content-card {
            padding: 40px 30px;
        }

        .content-card p,
        .ajude-list li {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .doacao-wrapper {
            padding: 35px 25px;
        }

        .ajude-title h1 {
            font-size: 2rem;
        }

        .main-title h2 {
            font-size: 2.5rem;
            line-height: 1.1;
            -webkit-text-stroke: 25px #2f5233;
        }

        .hero-image {
            max-width: 100%;
            height: 500px;
        }

        .volunteers-image-wrapper {
            max-width: 100%;
            padding: 40px 0;
        }

        .section-title-verde h3 {
            font-size: 2rem;
        }

        .content-card {
            padding: 30px 25px;
        }

        .content-card p,
        .ajude-list li {
            font-size: 1.3rem;
        }

        .adote-btn {
            font-size: 2rem;
            padding: 5px 35px;
            border-radius: 15px;
        }
        
        .adote-btn i {
            font-size: 2rem;
        }

        .doacao-title {
            font-size: 1.8rem;
        }

        .qrcode-wrapper {
            padding: 30px 20px;
        }

        .pix-label {
            font-size: 1.2rem;
        }

        .qrcode-image {
            max-width: 250px;
        }

        .doacao-description {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 626px) {
        .main-title h2 {
            font-size: 2rem;
        }

        .adote-btn {
            font-size: 1.8rem;
            padding: 5px 35px;
            border-radius: 15px;
        }

        .adote-btn i {
            font-size: 1.8rem;
        }

        .section-title-verde h3 {
            font-size: 1.8rem;
        }

        .pix-sub-label {
            font-size: 0.8rem;
        }
    }
    
    @media (max-width: 512px) {
        .main-title h2 {
            font-size: 1.8rem;
            line-height: 1.1;
            -webkit-text-stroke: 18px #2f5233;
        }

        .adote-btn-wrapper {
            margin: -105px 0 50px;
        }

        .adote-btn {
            font-size: 1.4rem;
            padding: 3px 35px;
        }

        .adote-btn i {
            font-size: 1.4rem;
        }

        .content-card {
            padding: 25px 20px;
        }

        .section-title-verde h3 {
            font-size: 1.6rem;
        }
    }

    @media (max-width: 480px) {
        .main-title h2 {
            font-size: 1.7rem;
            -webkit-text-stroke: 18px #2f5233;
        }

        .hero-image {
            max-width: 100%;
            height: 400px;
        }

        .doacao-wrapper {
            padding: 25px 20px;
        }

        .content-card p,
        .ajude-list li {
            font-size: 1.0rem;
        }

        .ajude-list li {
            padding-left: 20px;
        }

        .adote-btn {
            font-size: 1.2rem;
            padding: 3px 30px;
        }

        .adote-btn i {
            font-size: 1.2rem;
        }

        .doacao-title {
            font-size: 1.5rem;
        }

        .qrcode-image {
            max-width: 200px;
        }
    }
</style>

<!-- Como Ajudar Section -->
<section class="section ajude-section">
    <hr class="linha-branca-responsiva">
    <div class="ajude-container">
        <div class="ajude-title">
            <h1><span class="como">COMO</span> <span class="ajudar">AJUDAR?</span></h1>
        </div>

        <!-- Container Imagem + Título Sobreposto -->
        <div class="hero-container">
            <img src="{{ asset('images/como-ajudar.jpg') }}" alt="Cachorro aguardando ajuda" class="hero-image">
            
            <div class="main-title">
                <h2>Tem um amigo<br>que precisa de você.</h2>
            </div>
        </div>

        <!-- Conteúdo Intercalado -->
        <div class="content-section">
            
            <!-- 1. Título no fundo verde -->
            <div class="section-title-verde">
                <h3>Ajude <span class="em">a</span> <span class="destaque">ONG Bicho do Mato!</span></h3>
            </div>

            <!-- 2. Card bege com descrição -->
            <div class="content-card">
                <p>A ONG Bicho do Mato trabalha todos os dias para resgatar, cuidar e dar uma nova chance a animais em situação de vulnerabilidade.</p>
            </div>

            <!-- 3. Título no fundo verde -->
            <div class="section-title-verde">
                <h3><span class="destaque">Existem várias formas de apoio:</span></h3>
            </div>

            <!-- 4. Card bege com lista -->
            <div class="content-card">
                <ul class="ajude-list">
                    <li><strong>Doações:</strong> contribua com ração, medicamentos e materiais de limpeza.</li>
                    <li><strong>Adoções:</strong> abra seu coração e sua casa para um dos nossos animais.</li>
                    <li><strong>Voluntariado:</strong> venha ajudar nos cuidados diários, eventos e campanhas de conscientização.</li>
                    <li><strong>Apadrinhamento:</strong> ajude a manter um animalzinho até ele encontrar um lar.</li>
                </ul>
            </div>

            <hr class="linha-branca-responsiva">
            <!-- 5. Título no fundo verde -->
            <div class="section-title-verde">
                <h3><span class="destaque">Quer ser voluntário ou apadrinhar de outra forma?</span></h3>
            </div>

            <!-- 6. Card bege com CTA -->
            <div class="content-card">
                <p>Entre em contato com a gente diretamente pelo app ou pelas nossas redes sociais! Juntos, podemos transformar vidas.</p>
            </div>
        </div>

        <!-- Imagem de Voluntários -->
        <div class="volunteers-image-wrapper">
            <img src="{{ asset('images/voluntarios.jpg') }}" alt="Voluntários com animais" class="volunteers-image">
        </div>

        <!-- Botão Adote Agora -->
        <div class="adote-btn-wrapper">
            <a 
                href="https://wa.me/555596219405?text=Ol%C3%A1%21%20Gostaria%20de%20apadrinhar%20um%20animal.%20Pode%20me%20passar%20mais%20informa%C3%A7%C3%B5es%2C%20por%20favor%3F"
                target="_blank"
                class="adote-btn"
            >
            <span>Apadrinhe <strong>Agora</strong></span>
            <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </div>
</section>

<!-- Doação Section -->
<section class="section doacao-section">
    <div class="doacao-container">
        <div class="doacao-wrapper">
            <h2 class="doacao-title">
                <span class="faca">Faça</span> 
                <span class="sua">sua</span> 
                <span class="doacao">Doação!</span>
            </h2>

            <div class="qrcode-wrapper">
                <p class="pix-label">PIX</p>
                <img src="{{ asset('images/pix/qrcode-pix.png') }}" alt="QR Code PIX" class="qrcode-image">
                <p class="pix-label" style="margin-bottom: 0;">CNPJ: 29.714.162/0001-73 </p>
                <p class="pix-sub-label">Santuário de Defesa Animal Bicho do Mato</p>
                <hr class="linha-verde-responsiva">
                <p class="doacao-description">
                    Doe qualquer valor e nos ajude a cuidar dos nossos animais resgatados. 
                    Sua contribuição faz a diferença!
                </p>
            </div>
        </div>
    </div>
</section>

@endsection