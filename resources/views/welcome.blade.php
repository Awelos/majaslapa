<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.welcome') }}</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        h1 {
            font-size: 3rem;
            color: #333;
        }
        .links {
            margin-top: 20px;
        }
        .links a {
            margin: 0 10px;
            text-decoration: none;
            color: #0077cc;
        }
    </style>
</head>
<body>
    <p>Locale sesijā: {{ session('locale') }}</p>
    <p>Aktīvais App::getLocale(): {{ App::getLocale() }}</p>

    <h1>{{ __('messages.welcome') }}</h1>

    <div class="links">
        <a href="{{ route('recipes.index') }}">{{ __('messages.add_recipe') }}</a> |
        <a href="{{ route('login') }}">{{ __('messages.login') }}</a> |
        <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
    </div>

    <div class="links" style="margin-top: 40px;">
        <a href="{{ route('lang.switch', 'lv') }}">LV</a> | 
        <a href="{{ route('lang.switch', 'en') }}">EN</a>
    </div>

</body>
</html>
