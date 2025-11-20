@extends('admin.layout')

@section('title', 'Editar Depoimento')
@section('page-title', 'Editar Depoimento')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Depoimentos', 'url' => route('admin.testimonials.index')],
        ['label' => 'Editar', 'url' => '']
    ];
@endphp

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit me-2"></i>Editar Depoimento #{{ $testimonial['id'] }}
            </div>
            
            <div class="card-body">
                <form action="{{ route('admin.testimonials.update', $testimonial['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $testimonial['name']) }}" required maxlength="100">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Descrição/Depoimento -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Depoimento <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" maxlength="500" required>{{ old('description', $testimonial['description']) }}</textarea>
                        <small class="text-muted">Máximo 500 caracteres</small>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Foto -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Foto</label>
                        
                        @if($testimonial['image'])
                            <div class="mb-2">
                                <p class="text-muted mb-2">Foto atual:</p>
                                <img src="{{ asset('storage/' . $testimonial['image']) }}" alt="{{ $testimonial['name'] }}" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f3a632;">
                            </div>
                        @endif
                        
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Deixe em branco para manter a foto atual</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <p class="text-muted mb-2">Nova foto:</p>
                            <img id="preview" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #f3a632;" alt="Preview">
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Atualizar Depoimento
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
