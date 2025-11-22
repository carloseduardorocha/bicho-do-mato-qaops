@extends('admin.layout')

@section('title', 'Parceiros')
@section('page-title', 'Gerenciar Parceiros')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Parceiros', 'url' => '']
    ];
@endphp

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-handshake me-2"></i>Lista de Parceiros</span>
        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Novo Parceiro
        </a>
    </div>
    
    <div class="card-body">
        @if($partners->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="100">Imagem</th>
                            <th>Nome</th>
                            <th>Link</th>
                            <th width="150" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partners as $partner)
                        <tr>
                            <td><strong>#{{ $partner->id }}</strong></td>
                            <td>
                                @if($partner->image)
                                    <img src="{{ asset('storage/' . $partner->image) }}" alt="{{ $partner->name }}" class="img-thumbnail" style="max-width: 60px; max-height: 60px; object-fit: contain;">
                                @else
                                    <span class="text-muted">Sem imagem</span>
                                @endif
                            </td>
                            <td><strong>{{ $partner->name }}</strong></td>
                            <td>
                                @if($partner->link)
                                    <a href="{{ $partner->link }}" target="_blank" class="text-decoration-none">
                                        <i class="fas fa-external-link-alt"></i> Visitar
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.partners.edit', $partner->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $partner->id }})" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $partner->id }}" action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST" style="display: none;">
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
                {{ $partners->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-handshake fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhum parceiro cadastrado ainda.</p>
                <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Primeiro Parceiro
                </a>
            </div>
        @endif
    </div>
</div>
@endsection