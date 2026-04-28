<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'EuCabanas | Sistema de Gestão' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('legacy-assets/assets/css/app-creative.min.css') }}">
    <link rel="stylesheet" href="{{ asset('legacy-assets/assets/css/icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/eucabanas-admin.css') }}">

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="euca-admin-shell">
    @php
        $navItems = [
            [
                'label' => 'Dashboard',
                'icon' => 'layout-dashboard',
                'active' => 'dashboard',
                'url' => route('dashboard'),
            ],
            ['label' => 'Produtos', 'icon' => 'package', 'active' => 'products.*', 'url' => route('products.index')],
        ];

        if (auth()->user()?->isAdmin()) {
            $navItems = array_merge($navItems, [
                [
                    'label' => 'Compras',
                    'icon' => 'shopping-cart',
                    'active' => 'orders.*',
                    'url' => route('orders.index'),
                ],
                ['label' => 'Usuários', 'icon' => 'users', 'active' => 'users.*', 'url' => route('users.index')],
                ['label' => 'Log Sistema', 'icon' => 'file-clock', 'active' => 'logs.*', 'url' => route('logs.index')],
            ]);
        }
    @endphp

    <nav class="euca-topbar">
        <div class="euca-brand">
            <a href="{{ route('dashboard') }}">
                <img src="{{ asset('assets/images/eucabanas-logo.png') }}" alt="EuCabanas">
            </a>
        </div>

        <button class="euca-mobile-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <i data-lucide="menu"></i>
        </button>

        <div id="mainNav" class="collapse navbar-collapse euca-nav-wrapper">
            <ul class="euca-nav">
                @foreach ($navItems as $item)
                    <li>
                        <a class="@if (request()->routeIs($item['active'])) active @endif" href="{{ $item['url'] }}">
                            <i data-lucide="{{ $item['icon'] }}"></i>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="euca-user-area">
                <div class="euca-user-copy">
                    <span>Operação</span>
                    <strong>{{ auth()->user()?->name ?? 'Systex' }}</strong>
                </div>

                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button class="euca-logout" type="submit">
                        <i data-lucide="log-out"></i>
                        Sair
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="euca-main">
        @if (session('status'))
            <div class="euca-alert euca-alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="euca-alert euca-alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>

    <script src="{{ asset('legacy-assets/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('legacy-assets/assets/js/app.min.js') }}"></script>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
