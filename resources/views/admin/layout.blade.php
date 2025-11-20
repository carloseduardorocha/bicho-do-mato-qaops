<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Bicho do Mato</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts - Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400&display=swap" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
    
    <style>
        :root {
            --verde: #2f5233;
            --verde-escuro: #1a2f1d;
            --amarelo: #f3a632;
            --amarelo-claro: #f5c366;
            --marrom: #5c3a21;
            --marrom-escuro: #3f2716;
            --bege: #f5e8d1;
            --bege-claro: #faf6ee;



            /* --verde: #2f5233;
            --verde-escuro: #1a2f1d;
            --amarelo: #f3a632;
            --marrom: #5c3a21;
            --bege: #f5e8d1; */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: var(--bege);
            padding-top: 70px;
        }

        a {
            color: var(--marrom-escuro);    
        }

        /* Navbar Fixa no Topo */
        .admin-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: var(--marrom);
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            z-index: 1050;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 15px;
            color: var(--amarelo);
            text-decoration: none;
            font-size: 1.5rem;
            font-weight: 900;
        }

        .navbar-brand:hover {
            color: var(--amarelo);
        }

        .navbar-menu {
            display: flex;
            align-items: center;
            gap: 5px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .navbar-menu li a {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .navbar-menu li a:hover,
        .navbar-menu li a.active {
            background: var(--amarelo);
            color: var(--marrom);
        }

        .navbar-menu li a i {
            font-size: 1.1rem;
        }

        .navbar-user {
            position: relative;
        }

        .user-dropdown {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 15px;
            background: var(--amarelo);
            color: var(--marrom);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 700;
            transition: all 0.3s ease;
            border: none;
        }

        .user-dropdown:hover {
            background: var(--marrom-escuro);
            color: var(--bege);
        }

        .user-dropdown i.fa-chevron-down {
            font-size: 0.8rem;
            transition: transform 0.3s ease;
        }

        .user-dropdown.active i.fa-chevron-down {
            transform: rotate(180deg);
        }

        .dropdown-menu-custom {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 10px;
            background: var(--amarelo);
            border-radius: 8px;
            box-shadow: 0 5px 20px var(--marrom);
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1060;
        }

        .dropdown-menu-custom:hover {
            background: var(--bege);
        }

        .dropdown-menu-custom.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu-custom::before {
            content: '';
            position: absolute;
            top: -8px;
            right: 20px;
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid var(--amarelo);
        }

        .dropdown-item-custom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            color: var(--marrom);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-item-custom:first-child {
            border-radius: 8px 8px 0 0;
        }

        .dropdown-item-custom:last-child {
            border-radius: 0 0 8px 8px;
        }

        .dropdown-item-custom:hover {
            background: var(--bege);
            color: var(--marrom);
        }

        .dropdown-item-custom i {
            font-size: 1.1rem;
        }

        .user-info {
            color: #fff;
            font-weight: 600;
        }

        /* Content Area */
        .content-area {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
            min-height: calc(100vh - 70px);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .card-header {
            background: var(--amarelo-claro);
            color: var(--marrom);
            border-radius: 10px 10px 0 0 !important;
            font-weight: 700;
            padding: 15px 20px;
        }

        .card-body {
            background-color: var(--bege-claro);
            border-radius: 0 0 10px 10px;
        }

        /* Buttons */
        .btn-primary {
            background: var(--amarelo);
            border-color: var(--amarelo);
            font-weight: 700;
            color: var(--marrom);
        }

        .btn-primary:hover {
            background: var(--marrom);
            border-color: var(--marrom);
            color: var(--bege);
        }

        .btn-warning {
            background: var(--amarelo);
            border-color: var(--amarelo);
            color: var(--bege);
            font-weight: 700;
        }

        .btn-warning:hover {
            background: var(--marrom);
            border-color: var(--marrom);
            color: var(--bege);
        }

        .btn-danger:hover {
            background: var(--marrom);
            border-color: var(--marrom);
            color: var(--bege);
        }

        /* Table */
        .table {
            background: var(--bege-claro);
        }

        .table thead th {
            background: var(--bege);
            color: var(--marrom);
            font-weight: 700;
            border: none;
        }

        .table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
            background: var(--bege);
        }

        .table tbody td,
        .table tbody td strong {
            color: var(--marrom);
        }

        .text-muted {
            color: #51280abf !important;
        }

        /* Alerts */
        .alert {
            border-radius: 10px;
            border: none;
            font-weight: 600;
        }

        /* Breadcrumb */
        .breadcrumb {
            background: transparent;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .breadcrumb-item.active {
            color: var(--marrom);
        }

        .form-control {
            color: var(--marrom-escuro);
            background-color: var(--bege);
        }

        .form-control:focus {
            background-color: var(--bege);
            border-color: var(--amarelo);
            box-shadow: 0 0 0 .25rem #f5c36682;
        }

        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0 30px var(--bege) inset !important;
            box-shadow: 0 0 0 30px var(--bege) inset !important;
            -webkit-text-fill-color: var(--marrom) !important;
        }

        /* Image Preview */
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            border-radius: 10px;
            border: 2px solid var(--bege);
        }

        #image::file-selector-button {
            background-color: var(--marrom);
            color: var(--bege);
        }

        #images::file-selector-button {
            background-color: var(--marrom);
            color: var(--bege);
        }

        /* Botão hamburguer */
        .navbar-toggler {
            background: none;
            border: none;
            color: var(--amarelo);
            font-size: 1.8rem;
            cursor: pointer;
        }

        .navbar-toggler:focus {
            outline: none;
        }

        /* Menu Mobile */
        .mobile-menu {
            position: fixed;
            top: 70px;
            left: 0;
            width: 100%;
            background: var(--marrom);
            padding: 15px 0;
            display: none;
            flex-direction: column;
            z-index: 2000;
        }

        .mobile-menu ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu ul li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            color: var(--bege);
            font-weight: 700;
            text-decoration: none;
            border-bottom: 1px solid #00000022;
        }

        .mobile-menu ul li a:hover {
            background: var(--amarelo);
            color: var(--marrom);
        }

        .mobile-logout-btn {
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            padding: 15px 20px;
            font-weight: 700;
            color: var(--bege);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-logout-btn:hover {
            background: var(--amarelo);
            color: var(--marrom);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .navbar-menu {
                display: none;
            }

            .navbar-user {
                display: none !important;
            }

            .admin-navbar {
                padding: 0 15px;
            }
        }

        @media (max-width: 768px) {
            body {
                padding-top: 60px;
            }

            .admin-navbar {
                height: 60px;
                flex-wrap: wrap;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }

            .user-info {
                display: none;
            }

            .content-area {
                padding: 20px 15px;
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navbar Fixa no Topo -->
    <nav class="admin-navbar">
        <a href="{{ route('admin.dashboard.index') }}" class="navbar-brand">
            <span>Painel Admin</span>
        </a>

        <ul class="navbar-menu">
            <li>
                <a href="{{ route('admin.dashboard.index') }}" class="{{ request()->routeIs('admin.dashboard.index') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.partners.index') }}" class="{{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                    <i class="fas fa-handshake"></i>
                    <span>Parceiros</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Notícias</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.testimonials.index') }}" class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i class="fas fa-comments"></i>
                    <span>Depoimentos</span>
                </a>
            </li>
        </ul>
        <div class="navbar-user">
            <button type="button" class="user-dropdown" id="userDropdown">
                <i class="fas fa-user-circle"></i>
                <span>{{ auth()->user()->name ?? 'Admin' }}</span>
                <i class="fas fa-chevron-down"></i>
            </button>
            
            <div class="dropdown-menu-custom" id="dropdownMenu">
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="dropdown-item-custom">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </div>
        <button class="navbar-toggler d-lg-none ms-auto" type="button" id="mobileMenuBtn">
            <i class="fas fa-bars"></i>
        </button>
    </nav>
    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="{{ route('admin.dashboard.index') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.partners.index') }}"><i class="fas fa-handshake"></i> Parceiros</a></li>
            <li><a href="{{ route('admin.news.index') }}"><i class="fas fa-newspaper"></i> Notícias</a></li>
            <li><a href="{{ route('admin.testimonials.index') }}"><i class="fas fa-comments"></i> Depoimentos</a></li>

            <li>
                <form action="{{ route('logout') }}" method="POST" style="width: 100%; margin:0;">
                    @csrf
                    <button type="submit" class="mobile-logout-btn">
                        <i class="fas fa-sign-out-alt"></i> Sair
                    </button>
                </form>
            </li>
        </ul>
    </div>

    <!-- Content -->
    <div class="content-area">
        <!-- Breadcrumb -->
        @if(isset($breadcrumbs))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active">{{ $breadcrumb['label'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    
    <!-- Dropdown Menu Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userDropdown = document.getElementById('userDropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');
            
            // Toggle dropdown
            userDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.classList.toggle('active');
                dropdownMenu.classList.toggle('show');
            });
            
            // Fechar dropdown ao clicar fora
            document.addEventListener('click', function(e) {
                if (!userDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    userDropdown.classList.remove('active');
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuBtn = document.getElementById('mobileMenuBtn');
        const menu = document.getElementById('mobileMenu');

        menuBtn.addEventListener('click', () => {
            menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        });
    });
    </script>

    <!-- SweetAlert2 Customização Bicho do Mato -->
    <script>
        // Configuração padrão do SweetAlert2 com as cores do projeto
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        // Função de confirmação de exclusão customizada
        function confirmDelete(id, formId = null) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Esta ação não poderá ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f3a632',
                cancelButtonColor: '#5c3a21',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId || `delete-form-${id}`);
                    if (form) {
                        form.submit();
                    }
                }
            });
        }

        // Função de confirmação de aprovação
        function confirmApprove(form) {
            event.preventDefault();
            Swal.fire({
                title: 'Aprovar depoimento?',
                text: "O depoimento será publicado no site.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#f3a632',
                cancelButtonColor: '#5c3a21',
                confirmButtonText: 'Sim, aprovar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Função de confirmação de rejeição
        function confirmReject(form) {
            event.preventDefault();
            Swal.fire({
                title: 'Rejeitar depoimento?',
                text: "O depoimento será excluído permanentemente.",
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#5c3a21',
                confirmButtonText: 'Sim, rejeitar!',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // Exibir mensagens de sessão automaticamente
        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: '{{ session('error') }}'
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: '{{ session('info') }}'
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: '{{ session('warning') }}'
            });
        @endif
    </script>
    
    @yield('scripts')
</body>
</html>