<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Viagens')</title>



    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="site-container">
        <aside class="sidebar">
            <h1 class="sidebar-title"><a href="{{ route('viagens.index') }}">Sistema de Viagens</a></h1>
            <ul class="sidebar-menu">
                <li><a href="{{ route('viagens.index') }}">Viagens</a></li>
            </ul>
            <ul class="sidebar-menu">
                <li><a href="{{ route('veiculos.index') }}">Veículos</a></li>
            </ul>
            <ul class="sidebar-menu">
                <li><a href="{{ route('motoristas.index') }}">Motoristas</a></li>
            </ul>
        </aside>
        <main class="main-content container">
            @yield('content')
        </main>
    </div>
</body>
</html>