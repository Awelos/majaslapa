<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ __('messages.site_title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <h1>{{ __('messages.site_name') }}</h1>
        <nav>
            <a href="{{ url('/') }}">{{ __('messages.home') }}</a>
            <a href="{{ route('recipes.index') }}">{{ __('messages.recipes') }}</a>
            @auth
                <a href="{{ route('recipes.create') }}">{{ __('messages.add_recipe') }}</a>
                <a href="{{ route('profile.edit') }}">{{ __('messages.profile') }}</a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_panel') }}</a>
                @endif
            @endauth
            @guest
                <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
            @endguest
            <a href="{{ route('lang.switch', 'lv') }}">LV</a> | 
            <a href="{{ route('lang.switch', 'en') }}">EN</a>
        </nav>
    </header>

    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
