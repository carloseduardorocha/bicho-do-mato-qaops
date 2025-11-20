@extends('admin.layout')

@section('title', 'Editar Parceiro')
@section('page-title', 'Editar Parceiro')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Parceiros', 'url' => route('admin.partners.index')],
        ['label' => 'Editar', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Editar Parceiro #{{ $partner['id'] }}
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.partners.update', $partner['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome do Parceiro <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $partner['name']) }}" required maxlength="100">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Logo/Imagem -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Logo/Imagem</label>
                        
                        @if($partner['image'])
                            <div class="mb-2">
                                <p class="text-muted mb-2">Imagem atual:</p>
                                <img src="{{ asset('storage/' . $partner['image']) }}" alt="{{ $partner['name'] }}" class="image-preview">
                            </div>
                        @endif
                        
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Deixe em branco para manter a imagem atual</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <p class="text-muted mb-2">Nova imagem:</p>
                            <img id="preview" class="image-preview" alt="Preview">
                        </div>
                    </div>

                    <!-- Link -->
                    <div class="mb-3">
                        <label for="link" class="form-label">Link (Rede Social/Site)</label>
                        <input type="url" class="form-control @error('link') is-invalid @enderror" id="link" name="link" value="{{ old('link', $partner['link']) }}" placeholder="https://exemplo.com" maxlength="255">
                        @error('link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Botões -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.partners.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Parceiro
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