
@extends('admin.layout')

@section('title', 'Editar Notícia')
@section('page-title', 'Editar Notícia')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Notícias', 'url' => route('admin.news.index')],
        ['label' => 'Editar', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Editar Notícia #{{ $news['id'] }}
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.news.update', $news['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Título -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $news['title']) }}" required maxlength="255">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descrição -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrição/Conteúdo <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="8" maxlength="5000" required>{{ old('description', $news['description']) }}</textarea>
                        <small class="text-muted">Máximo 5000 caracteres</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Imagens Atuais -->
                    @php
                        $currentImages = !empty($news['images']) ? json_decode($news['images'], true) : [];
                    @endphp

                    @if(!empty($currentImages))
                        <div class="mb-3">
                            <label class="form-label">Imagens Atuais</label>
                            <div class="row g-2" id="currentImagesContainer">
                                @foreach($currentImages as $index => $imagePath)
                                    <div class="col-6 col-md-4 col-lg-3" id="image-{{ $index }}">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Imagem {{ $index + 1 }}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                                            <button type="button" class="btn btn-warning btn-sm position-absolute top-0 end-0 m-1" onclick="deleteImage('{{ $imagePath }}', {{ $news['id'] }}, {{ $index }})" title="Remover imagem">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upload de Novas Imagens -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Adicionar Novas Imagens</label>
                        <input type="file" class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" id="images" name="images[]" accept="image/*" multiple onchange="previewMultipleImages(event)">
                        <small class="text-muted">As novas imagens serão adicionadas às já existentes. Formatos aceitos: JPG, PNG, GIF (máx. 2MB por imagem).</small>
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
                            <i class="fas fa-save"></i> Atualizar Notícia
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
    // Preview de múltiplas imagens novas
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

    // Deletar imagem individual via AJAX
    function deleteImage(imagePath, newsId, imageIndex) {
        Swal.fire({
            title: 'Remover imagem?',
            text: "Esta imagem será excluída permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#f3a632',
            cancelButtonColor: '#5c3a21',
            confirmButtonText: 'Sim, remover!',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // CORREÇÃO: URL correta conforme a rota definida
                fetch(`{{ route('admin.news.deleteImage', ['id' => ':id']) }}`.replace(':id', newsId), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        image_path: imagePath
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Remove o elemento da DOM
                        document.getElementById(`image-${imageIndex}`).remove();
                        
                        // Verifica se ainda existem imagens
                        const container = document.getElementById('currentImagesContainer');
                        if (container && container.children.length === 0) {
                            container.closest('.mb-3').remove();
                        }
                        
                        Toast.fire({
                            icon: 'success',
                            title: 'Imagem removida com sucesso!'
                        });
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: data.message || 'Erro ao remover imagem.'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Toast.fire({
                        icon: 'error',
                        title: 'Erro ao remover imagem.'
                    });
                });
            }
        });
    }
</script>
@endsection