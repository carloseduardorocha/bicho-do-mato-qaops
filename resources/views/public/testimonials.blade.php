@extends('layouts.app')

@section('title', 'Depoimentos - Bicho do Mato')

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

    .section {
        padding: 60px 5%;
        position: relative;
    }

    .depoimentos-page-section {
        background: transparent;
        padding-top: 60px;
        padding-bottom: 80px;
    }

    .depoimentos-page-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    /* Título */
    .depoimentos-page-title {
        text-align: center;
        margin-bottom: 50px;
    }

    .depoimentos-page-title h1 {
        color: #fff;
        font-size: 3.5rem;
        margin: 0;
    }

    .depoimentos-page-title .nossos {
        font-weight: 900;
        font-style: normal;
    }

    .depoimentos-page-title .depoimentos {
        font-weight: 200;
        font-style: italic;
    }

    /* Grid de Depoimentos com Scroll */
    .depoimentos-grid-wrapper {
        overflow-y: auto;
        padding-right: 10px;
        margin-bottom: 40px;
    }

    .depoimentos-grid-wrapper::-webkit-scrollbar {
        width: 8px;
    }

    .depoimentos-grid-wrapper::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .depoimentos-grid-wrapper::-webkit-scrollbar-thumb {
        background: #f3a632;
        border-radius: 10px;
    }

    .depoimentos-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .depoimento-card {
        background: #f5e8d1;
        border-radius: 20px;
        padding: 40px 30px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .depoimento-avatar {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #f3a632;
        margin-bottom: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
        margin-bottom: 15px;
    }

    .depoimento-texto {
        color: #2f5233;
        font-size: 1.1rem;
        line-height: 1.6;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
    }

    /* Formulário de Depoimento */
    .form-section-title {
        text-align: center;
        margin-bottom: 30px;
    }

    .form-section-title h2 {
        color: #fff;
        font-size: 2.5rem;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0;
    }

    .form-section-title .adicionar {
        font-weight: 900;
        font-style: normal;
    }

    .form-section-title .novo {
        font-weight: 300;
        font-style: italic;
    }

    .form-wrapper {
        background: #f3a632;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.4);
        max-width: 700px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        color: #2f5233;
        font-size: 1.2rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 10px;
    }

    .form-input,
    .form-textarea {
        width: 100%;
        padding: 15px 20px;
        background: #f5e8d1;
        border: none;
        border-radius: 10px;
        font-family: 'Nunito', sans-serif;
        font-size: 1.1rem;
        color: #2f5233;
        resize: none;
    }

    .form-input::placeholder,
    .form-textarea::placeholder {
        color: #9d8a6f;
        font-weight: 400;
    }

    .form-input:focus,
    .form-textarea:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(47, 82, 51, 0.3);
    }

    .form-textarea {
        min-height: 150px;
    }

    .char-count {
        text-align: right;
        color: #2f5233;
        font-size: 0.9rem;
        font-weight: 600;
        margin-top: 5px;
    }

    .file-upload-wrapper {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .file-upload-btn {
        background: #2f5233;
        color: #fff;
        padding: 12px 25px;
        border-radius: 10px;
        border: none;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.3s ease;
    }

    .file-upload-btn:hover {
        background: #5c3a21;
    }

    .file-upload-btn i {
        font-size: 1.2rem;
    }

    .file-input {
        display: none;
    }

    .file-name {
        color: #2f5233;
        font-size: 1rem;
        font-weight: 600;
        background: #f5e8d1;
        padding: 10px 15px;
        border-radius: 10px;
        flex: 1;
    }

    .form-buttons {
        display: flex;
        gap: 20px;
        margin-top: 30px;
    }

    .btn-submit,
    .btn-cancel {
        flex: 1;
        padding: 15px 30px;
        border: none;
        border-radius: 10px;
        font-size: 1.3rem;
        font-weight: 900;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit {
        background: #2f5233;
        color: #fff;
    }

    .btn-submit:hover {
        background: #1a2f1d;
        transform: translateY(-2px);
    }

    .btn-cancel {
        background: #d32f2f;
        color: #fff;
    }

    .btn-cancel:hover {
        background: #b71c1c;
        transform: translateY(-2px);
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
      .depoimentos-grid {
          grid-template-columns: repeat(2, 1fr);
      }
    }
    @media (max-width: 1000px) {
        .depoimentos-grid {
            grid-template-columns: 1fr;
        }

        .depoimentos-grid-wrapper {
            max-height: none;
        }
    }

    @media (max-width: 768px) {
        .section {
            padding: 40px 5%;
        }

        .depoimentos-page-title h1 {
            font-size: 2rem;
        }

        .form-section-title h2 {
            font-size: 2rem;
        }

        .form-wrapper {
            padding: 30px 20px;
        }

        .form-buttons {
            flex-direction: column;
        }

        .file-upload-wrapper {
            flex-direction: column;
            align-items: stretch;
        }
    }

    @media (max-width: 512px) {
        .depoimento-avatar {
            width: 120px;
            height: 120px;
        }

        .depoimento-card {
            padding: 30px 20px;
        }
    }

    @media (max-width: 480px) {

        .depoimento-nome {
            font-size: 1.2rem;
        }

        .depoimento-texto {
            font-size: 1rem;
        }
    }
</style>

<section class="section depoimentos-page-section">
    <hr class="linha-branca-responsiva">
    
    <div class="depoimentos-page-container">
        <div class="depoimentos-page-title">
            <h1><span class="nossos">NOSSOS</span> <span class="depoimentos">DEPOIMENTOS</span></h1>
        </div>

        <!-- Grid de Depoimentos com Scroll -->
        <div class="depoimentos-grid-wrapper">
            <div class="depoimentos-grid">
                {{-- @foreach($depoimentos as $depoimento) --}}
                
                <!-- Depoimento 1 -->
                <div class="depoimento-card">
                    <div class="depoimento-avatar">
                        <img src="{{ asset('images/depoimento.jpg') }}" alt="Gilberto Souza">
                    </div>
                    <h3 class="depoimento-nome">Gilberto Souza</h3>
                    <p class="depoimento-texto">Graças a ONG, encontrei o melhor amigo que eu poderia ter!</p>
                </div>

                <!-- Depoimento 2 -->
                <div class="depoimento-card">
                    <div class="depoimento-avatar">
                        <img src="{{ asset('images/depoimento.jpg') }}" alt="Cintia da Silva">
                    </div>
                    <h3 class="depoimento-nome">Cintia da Silva</h3>
                    <p class="depoimento-texto">Adotar o Thor foi uma das melhores decisões da minha vida. O aplicativo facilitou todo o processo...</p>
                </div>

                <!-- Depoimento 3 -->
                <div class="depoimento-card">
                    <div class="depoimento-avatar">
                        <img src="{{ asset('images/depoimento.jpg') }}" alt="Camila Fontes">
                    </div>
                    <h3 class="depoimento-nome">Camila Fontes</h3>
                    <p class="depoimento-texto">Adotei minha cachorrinha há 2 anos e foi a melhor decisão da minha vida. Eles têm tanto amor pra dar, só precisam de uma chance!</p>
                </div>

                <!-- Depoimento 4 -->
                <div class="depoimento-card">
                    <div class="depoimento-avatar">
                        <img src="{{ asset('images/depoimento.jpg') }}" alt="Bruno Oliveira">
                    </div>
                    <h3 class="depoimento-nome">Bruno Oliveira</h3>
                    <p class="depoimento-texto">Tem tanto bichinho esperando por um lar... Comprar nunca mais, agora só adoto! A gratidão deles é algo que não tem preço.</p>
                </div>

                {{-- @endforeach --}}
            </div>
        </div>

        <hr class="linha-branca-responsiva">

        <!-- Formulário de Adicionar Depoimento -->
        <div class="form-section-title">
            <h2><span class="adicionar">ADICIONAR</span> <span class="novo">NOVO DEPOIMENTO</span></h2>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('public.home') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nome -->
                <div class="form-group">
                    <label class="form-label" for="nome">Nome</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome" 
                        class="form-input" 
                        placeholder="Digite o seu nome completo..."
                        required
                    >
                </div>

                <!-- Título -->
                <div class="form-group">
                    <label class="form-label" for="titulo">Título</label>
                    <input 
                        type="text" 
                        id="titulo" 
                        name="titulo" 
                        class="form-input" 
                        placeholder="Digite o título do seu depoimento..."
                        maxlength="100"
                        required
                        oninput="updateCharCount('titulo', 'titulo-count', 100)"
                    >
                    <div class="char-count"><span id="titulo-count">0</span>/100</div>
                </div>

                <!-- Descrição -->
                <div class="form-group">
                    <label class="form-label" for="descricao">Descrição</label>
                    <textarea 
                        id="descricao" 
                        name="descricao" 
                        class="form-textarea" 
                        placeholder="Digite uma descrição..."
                        maxlength="250"
                        required
                        oninput="updateCharCount('descricao', 'descricao-count', 250)"
                    ></textarea>
                    <div class="char-count"><span id="descricao-count">0</span>/250</div>
                </div>

                <!-- Upload de Foto -->
                <div class="form-group">
                    <label class="form-label">Adicione sua foto</label>
                    <div class="file-upload-wrapper">
                        <button type="button" class="file-upload-btn" onclick="document.getElementById('foto').click()">
                            <i class="fas fa-camera"></i>
                            <span>Upload</span>
                        </button>
                        <input 
                            type="file" 
                            id="foto" 
                            name="foto" 
                            class="file-input" 
                            accept="image/*"
                            onchange="updateFileName()"
                            required
                        >
                        <div class="file-name" id="file-name">Nenhuma foto selecionada</div>
                    </div>
                </div>

                <!-- Botões -->
                <div class="form-buttons">
                    <button type="submit" class="btn-submit">Adicionar</button>
                    <button type="button" class="btn-cancel" onclick="resetForm()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    // Atualizar contador de caracteres
    function updateCharCount(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        counter.textContent = input.value.length;
    }

    // Atualizar nome do arquivo
    function updateFileName() {
        const input = document.getElementById('foto');
        const fileName = document.getElementById('file-name');
        
        if (input.files.length > 0) {
            fileName.textContent = input.files[0].name;
        } else {
            fileName.textContent = 'Nenhuma foto selecionada';
        }
    }

    // Resetar formulário
    function resetForm() {
        document.querySelector('form').reset();
        document.getElementById('titulo-count').textContent = '0';
        document.getElementById('descricao-count').textContent = '0';
        document.getElementById('file-name').textContent = 'Nenhuma foto selecionada';
    }
</script>

@endsection