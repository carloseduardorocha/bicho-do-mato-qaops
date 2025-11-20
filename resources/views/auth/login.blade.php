<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrativo - Bicho do Mato</title>
    
    <!-- Google Fonts - Nunito -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #2f5233;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Background decorativo com animais */
        .bg-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .bg-cat {
            position: absolute;
            top:0%;
            left: 40%;
            transform: translateX(-120%);
            width: 35vw;
            max-width: 450px;
            min-width: 250px;
            opacity: 0.15;
        }

        .bg-toucan {
            position: absolute;
            bottom: 0%;
            right: 40%;
            transform: translateX(100%);
            width: 40vw;
            max-width: 500px;
            min-width: 280px;
            opacity: 0.15;
        }

        /* Container principal */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 20px;
        }

        /* Botão voltar */
        .btn-back {
            position: absolute;
            top: 30px;
            right: 30px;
            background-color: #f3a632;
            border: none;
            border-radius: 12px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 100;
        }

        .btn-back:hover {
            background-color: #e69520;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-back i {
            color: #fff;
            font-size: 24px;
        }

        /* Logo */
        .logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo img {
            width: 280px;
            max-width: 100%;
            height: auto;
        }

        /* Card de login */
        .login-card {
            background: transparent;
            text-align: center;
        }

        .login-title {
            color: #fff;
            font-size: 26px;
            font-weight: 300;
            margin-bottom: 30px;
            letter-spacing: 2px;
        }

        .login-title strong {
            font-weight: 900;
        }

        /* Formulário */
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            color: #2f5233;
            font-size: 20px;
            z-index: 2;
        }

        .form-input {
            width: 100%;
            padding: 18px 20px 18px 55px;
            background-color: #f5e8d1;
            border: none;
            border-radius: 50px;
            font-family: 'Nunito', sans-serif;
            font-size: 16px;
            color: #5c3a21;
            outline: none;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: #2f5233;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .form-input:focus {
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(243, 166, 50, 0.3);
        }

        /* Toggle senha */
        .toggle-password {
            position: absolute;
            right: 20px;
            background: none;
            border: none;
            color: #5c3a21;
            font-size: 18px;
            cursor: pointer;
            z-index: 2;
            padding: 5px;
            transition: color 0.3s ease;
        }

        .toggle-password:hover {
            color: #f3a632;
        }

        /* Botão entrar */
        .btn-submit {
            width: 100%;
            max-width: 220px;
            padding: 16px 50px;
            background-color: #f3a632;
            border: none;
            border-radius: 50px;
            color: #fff;
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            font-weight: 700;
            font-style: italic;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 30px auto 25px;
            display: block;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn-submit:hover {
            background-color: #e69520;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .btn-back {
                top: 20px;
                right: 20px;
                width: 45px;
                height: 45px;
            }

            .btn-back i {
                font-size: 20px;
            }

            .logo img {
                width: 220px;
            }

            .login-title {
                font-size: 18px;
            }

            .form-input {
                padding: 16px 20px 16px 50px;
                font-size: 15px;
            }

            .bg-cat {
                display: none;
            }

            .bg-toucan {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .logo img {
                width: 180px;
            }

            .btn-submit {
                font-size: 16px;
                padding: 13px 35px;
            }
        }
    </style>
</head>
<body>
    <!-- Decoração de fundo -->
    <div class="bg-decoration">
        <!-- Substitua os caminhos pelas suas imagens -->
        <img src="{{ asset('images/gato-bg.png') }}" alt="" class="bg-cat">
        <img src="{{ asset('images/tucano-bg.png') }}" alt="" class="bg-toucan">
    </div>

    <!-- Botão Voltar -->
    <button class="btn-back" onclick="window.location.href='<?= route('public.home') ?>'">
        <i class="fas fa-undo-alt"></i>
    </button>

    <!-- Container de Login -->
    <div class="login-container">
        <div class="logo">
            <!-- Substitua pelo caminho da sua logo -->
            <img src="{{ asset('images/logo-bicho-do-mato.png') }}" alt="Bicho do Mato">
        </div>

        <div class="login-card">
            <h1 class="login-title"><strong>LOGIN</strong> ADMINISTRATIVO</h1>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Campo E-mail/Usuário -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-user input-icon"></i>
                        <input 
                            type="text" 
                            name="email" 
                            class="form-input" 
                            placeholder="E-mail ou Usuário"
                            required
                            autocomplete="username"
                        >
                    </div>
                </div>

                <!-- Campo Senha -->
                <div class="form-group">
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-input" 
                            placeholder="Senha"
                            required
                            autocomplete="current-password"
                        >
                        <button 
                            type="button" 
                            class="toggle-password" 
                            onclick="togglePassword()"
                            aria-label="Mostrar/Ocultar senha"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Botão Entrar -->
                <button type="submit" class="btn-submit">Entrar</button>
            </form>
        </div>
    </div>

    <script>
        // Toggle para mostrar/ocultar senha
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Prevenir submissão dupla do formulário
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Entrando...';
        });
    </script>
</body>
</html>