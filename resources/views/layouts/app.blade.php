<!DOCTYPE html>
<html>
<head>
    <title>Recepšu meklētājs</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>Mans recepšu portāls</h1>
        <nav>
            <a href="/">Sākums</a>
            <a href="{{ route('recipes.index') }}">Receptes</a>
            @auth
                <a href="{{ route('recipes.create') }}">Pievienot recepti</a>
                <a href="{{ route('profile.edit') }}">Mans profils</a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin Panelis</a>
                @endif
            @endauth
            @guest
                <a href="{{ route('login') }}">Pieteikties</a>
                <a href="{{ route('register') }}">Reģistrēties</a>
            @endguest
        </nav>
    </header>

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
