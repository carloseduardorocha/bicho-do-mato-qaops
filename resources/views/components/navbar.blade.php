<!-- Google Fonts - Nunito -->
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">

<!-- Font Awesome para ícones -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Navbar */
    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background-image: url('{{ asset("images/background.jpg") }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 110px;
        padding: 0 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 25px;
        z-index: 1000;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Overlay escuro sobre o background para melhorar legibilidade */
    .navbar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4);
        z-index: -1;
    }

    /* Logo */
    .navbar-logo {
        display: flex;
        align-items: center;
        z-index: 2;
    }

    .navbar-logo img {
        height: 90px;
        width: auto;
    }

    /* Container do menu com fundo verde */
    .navbar-menu-wrapper {
        display: flex;
        align-items: center;
        background-color: rgba(47, 82, 51, 0.8);
        border-radius: 50px;
        padding: 3px 25px;
        z-index: 2;
    }

    /* Menu de navegação */
    .navbar-menu {
        display: flex;
        list-style: none;
        gap: 35px;
        align-items: center;
        z-index: 2;
        margin: 0;
    }

    .navbar-menu li {
        position: relative;
    }

    .navbar-menu a {
        color: #fff;
        text-decoration: none;
        text-align: center;
        font-size: 18px;
        font-weight: 400;
        font-style: italic;
        transition: color 0.3s ease;
        padding: 5px 0;
        display: inline-block;
        position: relative;
    }

    /* Pseudo-elemento invisível para manter o espaço */
    .navbar-menu a::before {
        content: attr(data-text);
        font-weight: 900;
        visibility: hidden;
        user-select: none;
        pointer-events: none;
        display: block;
        height: 0;     
    }


    /* Menu ativo */
    .navbar-menu a.active {
        font-weight: 900;
        color: #fff;
    }

    /* Hover */
    .navbar-menu a:hover {
        font-weight: 900;
        color: #f3a632;
    }

    /* Ícones de ação (notificação e admin) */
    .navbar-actions {
        display: flex;
        gap: 15px;
        align-items: center;
        z-index: 2;
    }

    .navbar-icon {
        background-color: #f3a632;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none;
    }

    .navbar-icon:hover {
        background-color: #e69520;
        transform: translateY(-2px);
        box-shadow: 0 5px 12px rgba(0, 0, 0, 0.3);
    }

    .navbar-icon i {
        color: #2f5233;
        font-size: 22px;
    }

    /* Menu hamburguer mobile */
    .navbar-toggle {
        display: none;
        background: #f3a632;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 8px;
        cursor: pointer;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 5px;
        z-index: 2;
    }

    .navbar-toggle span {
        width: 28px;
        height: 3px;
        background-color: #2f5233;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    /* Animação do menu hamburguer */
    .navbar-toggle.active span:nth-child(1) {
        transform: rotate(45deg) translate(7px, 7px);
    }

    .navbar-toggle.active span:nth-child(2) {
        opacity: 0;
    }

    .navbar-toggle.active span:nth-child(3) {
        transform: rotate(-45deg) translate(7px, -7px);
    }

    /* Espaço para conteúdo abaixo da navbar fixa */
    body {
        padding-top: 110px;
    }

    /* Responsividade */
    @media (max-width: 1200px) {
        .navbar {
            padding: 0 30px;
        }

        .navbar-menu-wrapper {
            padding: 3px 25px;
        }

        .navbar-menu {
            gap: 20px;
        }

        .navbar-menu a {
            font-size: 16px;
        }

        .navbar-logo img {
            height: 80px;
        }
    }

    @media (max-width: 1024px) {
        .navbar {
            padding: 0 25px;
        }

        .navbar-menu-wrapper {
            padding: 3px 25px;
        }

        .navbar-menu {
            gap: 15px;
        }

        .navbar-menu a {
            font-size: 15px;
        }

        .navbar-logo img {
            height: 70px;
        }
    }

    @media (max-width: 768px) {
        body {
            padding-top: 90px;
        }

        .navbar {
            padding: 0 20px;
            height: 90px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-logo img {
            height: 70px !important;
            width: auto;
        }

        .navbar-logo {
            order: 1;
            margin-right: auto;
        }

        .navbar-actions {
            order: 2;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .navbar-toggle {
            display: flex;
            order: 3;
            margin-left: 10px;
        }

        .navbar-menu {
            position: fixed;
            top: 90px;
            left: 0;
            width: 100%;
            background-color: rgba(47, 82, 51, 0.98);
            flex-direction: column;
            gap: 0;
            padding: 20px 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .navbar-menu.active {
            transform: translateX(0);
            display: flex;
        }
        .navbar-menu li {
            width: 100%;
            text-align: center;
        }
        .navbar-menu a {
            display: block;
            padding: 15px 20px;
            font-size: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .navbar-menu a:hover,
        .navbar-menu a.active {
            color: #f3a632;
        }
    }
</style>

<!-- Navbar -->
<nav class="navbar">
    <!-- Logo -->
    <div class="navbar-logo">
        <a href="{{ route('public.home') }}">
            <img src="{{ asset('images/logo-bicho-do-mato-contornado.png') }}" alt="Bicho do Mato">
        </a>
    </div>

    <!-- Menu de navegação -->
    <div class="navbar-menu-wrapper">
        <ul class="navbar-menu" id="navbarMenu">
            <li>
                <a href="{{ route('public.home') }}"
                class="{{ Route::is('public.home') ? 'active' : '' }}"
                data-text="Home">
                Início
                </a>
            </li>

            <li>
                <a href="{{ route('public.help') }}"
                class="{{ Route::is('public.help') ? 'active' : '' }}"
                data-text="Ajude">
                Ajuda
                </a>
            </li>

            <li>
                <a href="{{ route('public.about') }}"
                class="{{ Route::is('public.about') ? 'active' : '' }}"
                data-text="Institucional">
                Institucional
                </a>
            </li>

            <li>
                <a href="{{ route('public.news') }}"
                class="{{ Route::is('public.news') ? 'active' : '' }}"
                data-text="Notícias">
                Notícias
                </a>
            </li>

            <li>
                <a href="{{ route('public.testimonials') }}"
                class="{{ Route::is('public.testimonials') ? 'active' : '' }}"
                data-text="Depoimentos">
                Depoimentos
                </a>
            </li>

            <li>
                <a href="{{ route('public.partners') }}"
                class="{{ Route::is('public.partners') ? 'active' : '' }}"
                data-text="Parceiros">
                Parceiros
                </a>
            </li>
        </ul>
    </div>

    <!-- Ações (admin) -->
    <div class="navbar-actions">
        <a href="{{ route('login') }}" class="navbar-icon" title="Área Administrativa">
            <i class="fas fa-user-shield"></i>
        </a>
    </div>

    <!-- Botão hamburguer (mobile) -->
    <button class="navbar-toggle" id="navbarToggle" aria-label="Menu">
        <span></span>
        <span></span>
        <span></span>
    </button>
</nav>

<script>
    // Toggle menu mobile
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener('click', function() {
            this.classList.toggle('active');
            navbarMenu.classList.toggle('active');
        });

        // Fechar menu ao clicar em um link (mobile)
        const menuLinks = document.querySelectorAll('.navbar-menu a');
        menuLinks.forEach(link => {
            link.addEventListener('click', () => {
                navbarToggle.classList.remove('active');
                navbarMenu.classList.remove('active');
            });
        });

        // Fechar menu ao clicar fora dele
        document.addEventListener('click', (e) => {
            if (!navbarToggle.contains(e.target) && !navbarMenu.contains(e.target)) {
                navbarToggle.classList.remove('active');
                navbarMenu.classList.remove('active');
            }
        });
    }
</script>