@extends('admin.layout')

@section('title', 'Dashboard')

@section('styles')
<style>
    .dashboard-welcome {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 150px);
        background: linear-gradient(135deg, var(--marrom) 0%, var(--marrom-escuro) 100%);
        border-radius: 20px;
        padding: 40px 40px;
        text-align: center;
    }

    .logo-container {
        animation: fadeIn 1s ease-in-out;
    }

    .logo-container img {
        max-width: 300px;
        width: 100%;
        height: auto;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));
    }

    .welcome-text {
        color: var(--amarelo);
        font-size: 2.5rem;
        font-weight: 800;
        text-align: center;
        margin-top: 20px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        animation: fadeIn 1.5s ease-in-out;
    }

    .welcome-subtitle {
        color: var(--bege);
        font-size: 1.2rem;
        font-weight: 600;
        text-align: center;
        margin-top: 15px;
        animation: fadeIn 2s ease-in-out;
    }

    /* Stats Cards */
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-top: 25px;
        max-width: 900px;
        width: 100%;
        animation: fadeIn 2.5s ease-in-out;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(243, 166, 50, 0.3);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(243, 166, 50, 0.2);
        border-color: #f3a632;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: #f3a632;
        margin-bottom: 15px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 900;
        color: #fff;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 1rem;
        color: var(--bege);
        font-weight: 600;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-welcome {
            padding: 40px 20px;
            min-height: calc(100vh - 120px);
        }

        .logo-container img {
            max-width: 300px;
        }

        .welcome-text {
            font-size: 2rem;
        }

        .welcome-subtitle {
            font-size: 1rem;
        }

        .stats-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<div class="dashboard-welcome">
    <div class="logo-container">
        <img src="{{ asset('images/logo-bicho-do-mato.png') }}" alt="Bicho do Mato">
    </div>
    
    <h1 class="welcome-text">
        Bem-vindo ao Painel Administrativo!
    </h1>
    
    <p class="welcome-subtitle">
        Sistema de Gerenciamento - Bicho do Mato
    </p>

    <!-- Cards de Estatísticas -->
    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-handshake"></i>
            </div>
            <div class="stat-value">{{ $partnersCount ?? 0 }}</div>
            <div class="stat-label">Parceiros</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <div class="stat-value">{{ $newsCount ?? 0 }}</div>
            <div class="stat-label">Notícias</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-comments"></i>
            </div>
            <div class="stat-value">{{ $testimonialsCount ?? 0 }}</div>
            <div class="stat-label">Depoimentos</div>
        </div>
    </div>
</div>
@endsection