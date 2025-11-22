@extends('admin.layout')

@section('title', 'Notícias')
@section('page-title', 'Gerenciar Notícias')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Notícias', 'url' => '']
    ];
@endphp

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-newspaper me-2"></i>Lista de Notícias</span>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Nova Notícia
        </a>
    </div>
    
    <div class="card-body">
        @if($news->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th width="80">ID</th>
                            <th width="120">Imagens</th>
                            <th>Título</th>
                            <th>Descrição</th>
                            <th width="150" class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $item)
                        <tr>
                            <td><strong>#{{ $item->id }}</strong></td>
                            <td>
                                @php
                                    $images = !empty($item->images) ? json_decode($item->images, true) : [];
                                @endphp
                                
                                @if(!empty($images))
                                    <div class="d-flex gap-1">
                                        <img src="{{ asset('storage/' . $images[0]) }}" alt="Imagem da notícia" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                        @if(count($images) > 1)
                                            <span class="badge bg-secondary align-self-center">+{{ count($images) - 1 }}</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">Sem imagens</span>
                                @endif
                            </td>
                            <td><strong>{{ $item->title }}</strong></td>
                            <td>
                                <span class="text-muted">{{ Str::limit($item->description, 80) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.news.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $item->id }})" title="Excluir">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <form id="delete-form-{{ $item->id }}" action="{{ route('admin.news.destroy', $item->id) }}" method="POST" style="display: none;">
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
                {{ $news->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <p class="text-muted">Nenhuma notícia cadastrada ainda.</p>
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Cadastrar Primeira Notícia
                </a>
            </div>
        @endif
    </div>
</div>
@endsection