@extends('admin.layout')

@section('title', 'Novo Depoimento')
@section('page-title', 'Cadastrar Depoimento')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Depoimentos', 'url' => route('admin.testimonials.index')],
        ['label' => 'Novo', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-plus-circle me-2"></i>Cadastrar Novo Depoimento
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required maxlength="100" placeholder="Nome de quem está dando o depoimento">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descrição/Depoimento -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Depoimento <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" maxlength="500" required placeholder="Escreva aqui o depoimento...">{{ old('description') }}</textarea>
                        <small class="text-muted">Máximo 500 caracteres</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto (Opcional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Formatos aceitos: JPG, PNG, GIF (máx. 2MB)</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <p class="text-muted mb-2">Preview:</p>
                            <img id="preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f3a632;" alt="Preview">
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Salvar Depoimento
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
    function previewImage(event) {
        const preview = document.getElementById('preview');
        const previewDiv = document.getElementById('imagePreview');
        const file = event.target.files[0];
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewDiv.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection