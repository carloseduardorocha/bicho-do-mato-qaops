@extends('layouts.app')

@section('title', 'Notícia - Bicho do Mato')

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

    /* Notícia Section */
    .noticia-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 80px;
    }

    .noticia-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Título Ler Notícia */
    .noticia-title {
        text-align: center;
        margin-bottom: 40px;
    }

    .noticia-title h1 {
        color: #fff;
        font-size: 3.5rem;
        margin: 0;
    }

    .noticia-title .noticia {
        font-weight: 200;
        font-style: italic;
    }

    /* Linha divisória branca */
    .linha-branca-responsiva {
        border: none;
        height: 1.5px;
        background-color: white;
        width: 650px;
        margin: 20px auto;
        max-width: calc(100% - 20px);
    }

    /* Seção de Conteúdo */
    .content-section {
        margin-top: 40px;
    }

    /* Título no fundo verde (sem card) */
    .section-title-verde {
        text-align: center;
        margin: 50px 0 30px;
    }

    .section-title-verde h3 {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 800;
        line-height: 1.4;
    }

    .section-title-verde .fotos {
        font-weight: 900;
        font-style: normal;
    }

    .section-title-verde .da-noticia {
        font-weight: 200;
        font-style: italic;
    }

    /* Card bege para conteúdo */
    .content-card {
        background: rgba(47, 82, 51, 0.85);
        border-radius: 20px;
        padding: 50px 60px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        margin-bottom: 40px;
    }

    .content-card p {
        color: #f5e8d1;
        font-size: 1.5rem;
        line-height: 1.8;
        text-align: justify;
        margin: 0;
        font-weight: 600;
    }

    /* Grid de Fotos */
    .fotos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 30px;
        margin-bottom: 60px;
    }

    .foto-item {
        position: relative;
        width: 100%;
        height: 350px;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .foto-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.5);
    }

    .foto-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.3s ease;
    }

    .foto-item:hover img {
        transform: scale(1.05);
    }

    /* Modal de Foto (Lightbox) */
    .foto-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.95);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .foto-modal.active {
        display: flex;
    }

    .modal-content {
        position: relative;
        max-width: 90%;
        max-height: 90%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-image {
        max-width: 100%;
        max-height: 90vh;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.8);
    }

    /* Botão Fechar */
    .close-modal {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 50px;
        height: 50px;
        background: #f3a632;
        border: none;
        border-radius: 50%;
        color: #fff;
        font-size: 2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-modal:hover {
        background: #5c3a21;
        transform: rotate(90deg);
    }

    /* Setas de Navegação */
    .modal-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 60px;
        height: 60px;
        background: #f3a632;
        border: none;
        border-radius: 50%;
        color: #fff;
        font-size: 2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10001;
    }

    .modal-nav:hover {
        background: #5c3a21;
        transform: translateY(-50%) scale(1.1);
    }

    .modal-nav.prev {
        left: 20px;
    }

    .modal-nav.next {
        right: 20px;
    }

    /* Contador de Fotos */
    .foto-counter {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(47, 82, 51, 0.9);
        color: #fff;
        padding: 10px 25px;
        border-radius: 50px;
        font-size: 1.2rem;
        font-weight: 700;
        z-index: 10001;
    }

    /* Botão Voltar */
    .voltar-btn-wrapper {
        text-align: center;
        margin: 40px 0 0;
    }

    .voltar-btn {
        display: inline-flex;
        align-items: center;
        gap: 15px;
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
        text-decoration: none;
    }

    .voltar-btn:hover {
        background: #5c3a21;
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(92, 58, 33, 0.5);
        color: #fff;
    }

    .voltar-btn i {
        font-size: 1.3rem;
    }

    /* Responsividade */
    @media (max-width: 1024px) {
        .fotos-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
        }

        .foto-item {
            height: 300px;
        }
    }

    @media (max-width: 910px) {
        .section-title-verde h3 {
            font-size: 2.2rem;
        }

        .content-card {
            padding: 40px 30px;
        }

        .content-card p {
            font-size: 1.3rem;
        }

        .voltar-btn {
            font-size: 1.2rem;
            padding: 12px 50px;
        }

        .voltar-btn i {
            font-size: 1.2rem;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .noticia-title h1 {
            font-size: 2rem;
        }

        .section-title-verde h3 {
            font-size: 2rem;
        }

        .content-card {
            padding: 30px 25px;
        }

        .content-card p {
            font-size: 1.2rem;
        }

        .fotos-grid {
            gap: 20px;
        }

        .foto-item {
            height: 250px;
        }

        .modal-nav {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
        }

        .close-modal {
            width: 45px;
            height: 45px;
            font-size: 1.5rem;
        }

        .voltar-btn {
            font-size: 1.1rem;
            padding: 12px 45px;
        }

        .voltar-btn i {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 626px) {
        .section-title-verde h3 {
            font-size: 1.8rem;
        }

        .fotos-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    @media (max-width: 512px) {
        .section-title-verde h3 {
            font-size: 1.6rem;
        }

        .content-card {
            padding: 25px 20px;
        }

        .content-card p {
            font-size: 1.1rem;
        }

        .foto-item {
            height: 220px;
        }

        .modal-nav {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
        }

        .close-modal {
            width: 40px;
            height: 40px;
            font-size: 1.3rem;
            top: 15px;
            right: 15px;
        }

        .foto-counter {
            font-size: 1rem;
            padding: 8px 20px;
        }

        .voltar-btn {
            font-size: 1.0rem;
            padding: 10px 40px;
        }

        .voltar-btn i {
            font-size: 1.0rem;
        }
    }

    @media (max-width: 480px) {
        .content-card p {
            font-size: 1.0rem;
        }

        .foto-item {
            height: 200px;
        }

        .modal-nav.prev {
            left: 10px;
        }

        .modal-nav.next {
            right: 10px;
        }

        .voltar-btn {
            font-size: 0.9rem;
            padding: 10px 35px;
            gap: 10px;
        }

        .voltar-btn i {
            font-size: 0.9rem;
        }
    }
</style>

<!-- Notícia Section -->
<section class="section noticia-section">
    <hr class="linha-branca-responsiva">    
    <div class="noticia-container">
        <div class="noticia-title">
            <h1><span class="noticia">Adoção de gatos registra aumento e traz esperança para protetores</span></h1>
        </div>

        <!-- Conteúdo da Notícia -->
        <div class="content-section">
            <!-- Card com descrição -->
            <div class="content-card">
                <p>
                    {{-- @if(isset($noticia)) --}}
                        {{-- {{ $noticia->descricao }} --}}
                    {{-- @else --}}
                        Nos últimos meses, ONGs e abrigos de proteção animal em diversas regiões do país têm comemorado uma boa notícia: o aumento nas adoções de gatos. Dados informais coletados por instituições como a ONG Bicho do Mato e outras organizações apontam um crescimento significativo na procura por felinos, especialmente após campanhas de conscientização intensificadas nas redes sociais.
                        <br><br>
                        Especialistas em comportamento animal e protetores independentes apontam que esse avanço se deve à combinação de fatores. "A maior visibilidade dos gatos nas redes sociais, a percepção de que são animais independentes e adaptáveis a ambientes menores — como apartamentos — e a conscientização sobre a importância da adoção responsável são os principais motivos por trás da mudança", explica Ana Paula Ribeiro, voluntária da ONG Bicho do Mato.
                        <br><br>
                        "Antes, os gatos eram deixados de lado nas feiras de adoção, onde os cães costumavam chamar mais atenção. Hoje, as pessoas estão mais abertas a conhecer e se apaixonar pelos felinos", comenta o veterinário Fernando Dias. "Muitas pessoas passaram a buscar companhia e conforto nos animais. E os gatos, com sua presença tranquila, se tornaram uma escolha popular."
                    {{-- @endif --}}
                </p>
            </div>

            <hr class="linha-branca-responsiva">

            <!-- Fotos no fundo verde -->
            <div class="section-title-verde">
                <h3><span class="fotos">FOTOS</span> <span class="da-noticia">da notícia</span></h3>
            </div>

            <!-- Grid de Fotos -->
            <div class="fotos-grid">
                {{-- @foreach($noticia->fotos as $foto) --}}
                    <div class="foto-item" onclick="openModal(0)">
                        <img src="{{ asset('images/arara.jpg') }}" alt="Foto da notícia">
                    </div>
                {{-- @endforeach --}}

                <div class="foto-item" onclick="openModal(1)">
                    <img src="{{ asset('images/arara.jpg') }}" alt="Foto da notícia">
                </div>

                <div class="foto-item" onclick="openModal(2)">
                    <img src="{{ asset('images/arara.jpg') }}" alt="Foto da notícia">
                </div>

                <div class="foto-item" onclick="openModal(3)">
                    <img src="{{ asset('images/arara.jpg') }}" alt="Foto da notícia">
                </div>

                <div class="foto-item" onclick="openModal(4)">
                    <img src="{{ asset('images/arara.jpg') }}" alt="Foto da notícia">
                </div>
            </div>

            <!-- Botão Voltar para Notícias -->
            <div class="voltar-btn-wrapper">
                <a href="{{ route('public.home') }}/noticias" class="voltar-btn">
                    <span>Voltar para o Início</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modal de Foto (Lightbox) -->
<div class="foto-modal" id="fotoModal" onclick="closeModalOnOverlay(event)">
    <button class="close-modal" onclick="closeModal()">
        <i class="fas fa-times"></i>
    </button>

    <button class="modal-nav prev" onclick="changePhoto(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>

    <div class="modal-content">
        <img src="" alt="Foto ampliada" class="modal-image" id="modalImage">
    </div>

    <button class="modal-nav next" onclick="changePhoto(1)">
        <i class="fas fa-chevron-right"></i>
    </button>

    <div class="foto-counter">
        <span id="currentPhoto">1</span> / <span id="totalPhotos">5</span>
    </div>
</div>

<script>
    // Array de fotos (será gerado dinamicamente pelo backend)
    const fotos = [
        '<?= asset('images/arara.jpg') ?>',
        '<?= asset('images/noticia-cachorro.jpg') ?>',
        '<?= asset('images/parceiro.jpg') ?>',
        '<?= asset('images/arara.jpg') ?>',
        '<?= asset('images/arara.jpg') ?>'
    ];

    let currentIndex = 0;

    // Abrir modal
    function openModal(index) {
        currentIndex = index;
        const modal = document.getElementById('fotoModal');
        const modalImage = document.getElementById('modalImage');
        const currentPhoto = document.getElementById('currentPhoto');
        const totalPhotos = document.getElementById('totalPhotos');

        modalImage.src = fotos[currentIndex];
        currentPhoto.textContent = currentIndex + 1;
        totalPhotos.textContent = fotos.length;

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    // Fechar modal
    function closeModal() {
        const modal = document.getElementById('fotoModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Fechar modal ao clicar no overlay (fundo escuro)
    function closeModalOnOverlay(event) {
        if (event.target.id === 'fotoModal') {
            closeModal();
        }
    }

    // Trocar foto no carrossel
    function changePhoto(direction) {
        currentIndex += direction;

        // Loop infinito
        if (currentIndex < 0) {
            currentIndex = fotos.length - 1;
        } else if (currentIndex >= fotos.length) {
            currentIndex = 0;
        }

        const modalImage = document.getElementById('modalImage');
        const currentPhoto = document.getElementById('currentPhoto');

        modalImage.src = fotos[currentIndex];
        currentPhoto.textContent = currentIndex + 1;
    }

    // Atalhos de teclado
    document.addEventListener('keydown', function(event) {
        const modal = document.getElementById('fotoModal');
        
        if (modal.classList.contains('active')) {
            if (event.key === 'Escape') {
                closeModal();
            } else if (event.key === 'ArrowLeft') {
                changePhoto(-1);
            } else if (event.key === 'ArrowRight') {
                changePhoto(1);
            }
        }
    });
</script>

@endsection