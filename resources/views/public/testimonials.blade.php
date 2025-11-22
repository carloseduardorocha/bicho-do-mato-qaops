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

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 40px;
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

    /* Toast Customizado */
    #custom-toast {
        position: fixed;
        top: 40px;
        left: 50%;
        transform: translateX(-50%);
        background: #f3a632;
        color: #2f5233;
        padding: 20px 30px;
        border-radius: 15px;
        font-size: 1.3rem;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-width: 300px;
        max-width: 600px;
        opacity: 0;
        pointer-events: none;
        transition: all 0.5s ease;
        z-index: 9999;
    }

    #custom-toast.toast-show {
        opacity: 1;
        pointer-events: auto;
        top: 80px;
    }

    #custom-toast.toast-success {
        background-color: #f3a632;
        color: #2f5233;
    }

    #custom-toast.toast-error {
        background-color: #d32f2f;
        color: #fff;
    }

    #custom-toast button {
        background: transparent;
        border: none;
        font-size: 1.5rem;
        color: inherit;
        cursor: pointer;
        margin-left: 20px;
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
                 @foreach($testimonials as $testimonial)
                    <div class="depoimento-card">
                        <div class="depoimento-avatar">
                            <img src="{{ asset('storage/' . $testimonial['image']) }}" alt="{{ $testimonial['name'] }}">
                        </div>
                        <h3 class="depoimento-nome">{{ $testimonial['name'] }}</h3>
                        <p class="depoimento-texto">{{ $testimonial['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        <!-- Paginação -->
        <div class="pagination-wrapper">
            <ul class="pagination">
                {{-- Previous --}}
                @if ($testimonials->onFirstPage())
                    <li class="disabled"><span>&laquo;</span></li>
                @else
                    <li><a href="{{ $testimonials->previousPageUrl() }}">&laquo;</a></li>
                @endif

                {{-- Números --}}
                @foreach ($testimonials->getUrlRange(1, $testimonials->lastPage()) as $page => $url)
                    @if ($page == $testimonials->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach

                {{-- Next --}}
                @if ($testimonials->hasMorePages())
                    <li><a href="{{ $testimonials->nextPageUrl() }}">&raquo;</a></li>
                @else
                    <li class="disabled"><span>&raquo;</span></li>
                @endif
            </ul>
        </div>

        <hr class="linha-branca-responsiva">

        <!-- Formulário de Adicionar Depoimento -->
        <div class="form-section-title">
            <h2><span class="adicionar">ADICIONAR</span> <span class="novo">NOVO DEPOIMENTO</span></h2>
        </div>

        <div class="form-wrapper">
            <form action="{{ route('public.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nome -->
                <div class="form-group">
                    <label class="form-label" for="nome">Nome <span style="color:red;">*</span></label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome" 
                        class="form-input" 
                        placeholder="Digite o seu nome completo..."
                        required
                    >
                </div>

                <!-- Descrição -->
                <div class="form-group">
                    <label class="form-label" for="descricao">Descrição <span style="color:red;">*</span></label>
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
                    <label class="form-label">Adicione sua foto <span style="color:red;">*</span></label>
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
<div id="custom-toast" class="toast-hidden">
    <span id="toast-message"></span>
    <button id="toast-close">&times;</button>
</div>

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

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toast = document.getElementById('custom-toast');
    const toastMessage = document.getElementById('toast-message');
    const toastClose = document.getElementById('toast-close');

    function showToast(message, type = 'success', duration = 5000) {
        toastMessage.textContent = message;
        toast.className = `toast-show toast-${type}`;

        // Fechar automaticamente
        setTimeout(() => {
            toast.className = 'toast-hidden';
        }, duration);
    }

    // Botão de fechar
    toastClose.addEventListener('click', () => {
        toast.className = 'toast-hidden';
    });

    // Mensagens do Laravel
    @if(session('success'))
        showToast(@json(session('success')), 'success', 5000);
    @endif

    @if(session('error'))
        showToast(@json(session('error')), 'error', 5000);
    @endif
});
</script>

@endsection