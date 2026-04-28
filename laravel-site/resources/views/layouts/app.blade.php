<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Eucabanas Estoque | Systex' }}</title>
    <link rel="stylesheet" href="{{ asset('legacy-assets/assets/css/app-creative.min.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-assets/assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/eucabanas-admin.css') }}">
</head>
<body class="systex-shell">
    @php
        $navItems = [
            ['label' => 'Dashboard', 'active' => 'dashboard', 'url' => route('dashboard')],
            ['label' => 'Produtos', 'active' => 'products.*', 'url' => route('products.index')],
        ];

        if (auth()->user()?->isAdmin()) {
            $navItems = array_merge($navItems, [
                ['label' => 'Compras', 'active' => 'orders.*', 'url' => route('orders.index')],
                ['label' => 'Usuários', 'active' => 'users.*', 'url' => route('users.index')],
                ['label' => 'Log Sistema', 'active' => 'logs.*', 'url' => route('logs.index')],
            ]);
        }
    @endphp

    <nav class="navbar navbar-expand-lg navbar-dark systex-navbar">
        <div class="container-fluid px-lg-4">
            <a class="navbar-brand brand-lockup" href="{{ route('dashboard') }}" aria-label="Eucabanas Estoque">
                <span class="brand-mark">SX</span>
                <span>
                    <span class="brand-title">Eucabanas Estoque</span>
                    <span class="brand-subtitle">Systex Hospitality</span>
                </span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="mainNav" class="collapse navbar-collapse">
                <ul class="navbar-nav systex-nav mx-lg-auto">
                    @foreach ($navItems as $item)
                        <li class="nav-item">
                            <a class="nav-link @if (request()->routeIs($item['active'])) active @endif" href="{{ $item['url'] }}">
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="operator-cluster">
                    <div class="operator-copy">
                        <span>Operação</span>
                        <strong>{{ auth()->user()?->name ?? 'Systex' }}</strong>
                    </div>
                    <form method="post" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-outline-light btn-sm" type="submit">Sair</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="app-stage">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('legacy-assets/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('legacy-assets/assets/js/app.min.js') }}"></script>
</body>
</html>
