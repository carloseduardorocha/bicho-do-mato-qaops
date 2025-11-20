@extends('admin.layout')

@section('title', 'Nova Notícia')
@section('page-title', 'Cadastrar Notícia')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Notícias', 'url' => route('admin.news.index')],
        ['label' => 'Nova', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2"></i>Cadastrar Nova Notícia
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Título -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required maxlength="255" placeholder="Título da notícia">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição/Conteúdo <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="8" maxlength="5000" required placeholder="Escreva aqui o conteúdo da notícia...">{{ old('description') }}</textarea>
                        <small class="text-muted">Máximo 5000 caracteres</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Upload Múltiplo de Imagens -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Imagens (Múltiplas)</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple onchange="previewMultipleImages(event)">
                        <small class="text-muted">Formatos aceitos: JPG, PNG, GIF (máx. 2MB por imagem). Você pode selecionar várias imagens.</small>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="imagesPreview" class="mt-3 row g-2" style="display: none;"></div>
                    </div>

                    <!-- Botões -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.news.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Notícia
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function previewMultipleImages(event) {
        const previewContainer = document.getElementById('imagesPreview');
        const files = event.target.files;
        
        if (files.length > 0) {
            previewContainer.innerHTML = '';
            previewContainer.style.display = 'flex';
            
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-4 col-lg-3';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail';
                    img.style.width = '100%';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';
                    
                    col.appendChild(img);
                    previewContainer.appendChild(col);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection