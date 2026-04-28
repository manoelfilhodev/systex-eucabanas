<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Eucabanas Estoque</title>
    <link rel="stylesheet" href="{{ asset('legacy-assets/assets/css/app-creative.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/eucabanas-admin.css') }}">
</head>
<body class="auth-premium">
    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card auth-card">
                        <div class="card-header pt-4 pb-4 text-center">
                            <div class="brand-lockup justify-content-center">
                                <span class="brand-mark">SX</span>
                                <span class="text-start">
                                    <span class="brand-title">Eucabanas Estoque</span>
                                    <span class="brand-subtitle">Systex Hospitality</span>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="page-kicker">Acesso seguro</div>
                                <h4 class="text-dark-50 mt-0 fw-bold">Bem-vindo</h4>
                                <p class="text-muted mb-0">Gestão diária de abastecimento, compras e auditoria operacional.</p>
                            </div>
                            <form method="post" action="{{ route('login.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="login">Login</label>
                                    <input class="form-control" id="login" name="login" value="{{ old('login') }}" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="password">Senha</label>
                                    <input class="form-control" id="password" type="password" name="password" required>
                                </div>
                                <div class="mb-3 form-check">
                                    <input class="form-check-input" id="remember" type="checkbox" name="remember" value="1">
                                    <label class="form-check-label" for="remember">Lembre-se de mim</label>
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                                @endif
                                <button class="btn btn-primary w-100" type="submit">Entrar</button>
                            </form>
                        </div>
                    </div>
                    <footer class="footer footer-alt text-white-50">{{ date('Y') }} &copy; Systex</footer>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
