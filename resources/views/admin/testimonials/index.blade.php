@extends('admin.layout')

@section('title', 'Depoimentos')
@section('page-title', 'Gerenciar Depoimentos')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Depoimentos', 'url' => '']
    ];
@endphp

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-comments me-2"></i>Lista de Depoimentos Aprovados</span>
        <div>
            <a href="{{ route('admin.testimonials.moderate') }}" class="btn btn-primary btn-sm me-2">
                <i class="fas fa-clock"></i> Moderar Pendentes
            </a>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Novo Depoimento
            </a>
        </div>
    </div>
    
    <div class="card-body">
        @if($testimonials->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="100">Foto</th>
                            <th>Nome</th>
                            <th>Depoimento</th>
                            <th width="150" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                        <tr>
                            <td><strong>#{{ $testimonial->id }}</strong></td>
                            <td>
                                @if($testimonial->image)
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="rounded-circle img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white" style="width: 60px; height: 60px; font-size: 1.5rem;">
                                        {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td><strong>{{ $testimonial->name }}</strong></td>
                            <td>
                                <span class="text-muted">{{ Str::limit($testimonial->description, 80) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $testimonial->id }})" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $testimonial->id }}" action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="justify-content-center mt-4">
                {{ $testimonials->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhum depoimento aprovado ainda.</p>
                <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Primeiro Depoimento
                </a>
            </div>
        @endif
    </div>
</div>
@endsection