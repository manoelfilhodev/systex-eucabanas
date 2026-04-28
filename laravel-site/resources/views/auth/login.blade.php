<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | EuCabanas Sistema de Gestão</title>

    <link rel="stylesheet" href="{{ asset('css/eucabanas-login.css') }}">
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="euca-login-page">

    <main class="euca-login-center">

        <section class="euca-login-card">
            <img src="{{ asset('assets/images/eucabanas-logo.png') }}" alt="EuCabanas" class="euca-logo">

            <div class="euca-title">
                <h1>Bem-vindo de volta!</h1>
                <p>Faça login para acessar o sistema</p>
            </div>

            <form method="post" action="{{ route('login.store') }}">
                @csrf

                <div class="euca-field">
                    <label for="login">E-mail</label>
                    <div class="euca-input">
                        <i data-lucide="user"></i>
                        <input id="login" name="login" value="{{ old('login') }}" required autofocus
                            placeholder="Digite seu e-mail">
                    </div>
                </div>

                <div class="euca-field">
                    <label for="password">Senha</label>
                    <div class="euca-input">
                        <i data-lucide="lock"></i>
                        <input id="password" type="password" name="password" required placeholder="Digite sua senha">
                        <i data-lucide="eye-off" class="euca-eye"></i>
                    </div>
                </div>

                <div class="euca-options">
                    <label>
                        <input type="checkbox" name="remember" value="1">
                        <span>Lembrar-me</span>
                    </label>

                    <a href="#">Esqueceu sua senha?</a>
                </div>

                @if ($errors->any())
                    <div class="euca-error">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button class="euca-btn-primary" type="submit">
                    <i data-lucide="log-in"></i>
                    Entrar
                </button>
            </form>

            <footer class="euca-footer">
                <i data-lucide="leaf"></i>
                © {{ date('Y') }} Eucabanas • Desenvolvido com ❤️ por Systex Sistemas Inteligentes
            </footer>
        </section>

    </main>

    <script>
        lucide.createIcons();
    </script>

</body>

</html>
