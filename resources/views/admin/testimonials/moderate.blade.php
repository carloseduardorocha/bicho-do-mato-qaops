@extends('admin.layout')

@section('title', 'Moderar Depoimentos')
@section('page-title', 'Moderação de Depoimentos')

@php
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['label' => 'Depoimentos', 'url' => route('admin.testimonials.index')],
        ['label' => 'Moderação', 'url' => '']
    ];
@endphp

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-clock me-2"></i>Depoimentos Aguardando Aprovação</span>
        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-arrow-left"></i> Ver Aprovados
        </a>
    </div>
    
    <div class="card-body">
        @if($pending->count() > 0)
            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle"></i> <strong>{{ $pending->total() }}</strong> depoimento(s) aguardando moderação.
            </div>

            @foreach($pending as $testimonial)
            <div class="card mb-3 border-warning">
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Foto -->
                        <div class="col-md-2 text-center">
                            @if($testimonial->image)
                                <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->name }}" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #f3a632;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white mx-auto" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    {{ strtoupper(substr($testimonial->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <!-- Conteúdo -->
                        <div class="col-md-7">
                            <h5 class="mb-2">
                                <i class="fas fa-user text-muted"></i> {{ $testimonial->name }}
                            </h5>
                            <p class="text-muted mb-1">
                                <small><i class="fas fa-calendar"></i> Enviado em: {{ \Carbon\Carbon::parse($testimonial->created_at)->format('d/m/Y H:i') }}</small>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-quote-left text-warning"></i>
                                {{ $testimonial->description }}
                                <i class="fas fa-quote-right text-warning"></i>
                            </p>
                        </div>

                        <!-- Ações -->
                        <div class="col-md-3 text-center">
                            <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="confirmApprove(this); return false;">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mb-2 w-100">
                                    <i class="fas fa-check"></i> Aprovar
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.testimonials.reject', $testimonial->id) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="confirmReject(this); return false;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm w-100">
                                    <i class="fas fa-times"></i> Rejeitar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Paginação -->
            <div class="justify-content-center mt-4">
                {{ $pending->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 class="text-muted">Nenhum depoimento pendente!</h5>
                <p class="text-muted">Todos os depoimentos foram moderados.</p>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-primary mt-3">
                    <i class="fas fa-arrow-left"></i> Voltar para Depoimentos
                </a>
            </div>
        @endif
    </div>
</div>
@endsection