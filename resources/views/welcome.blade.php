<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('messages.welcome') }}</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: #333;
        }

        .container {
            background: white;
            padding: 40px 60px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .info {
            font-size: 0.95rem;
            color: #666;
            margin-bottom: 30px;
        }

        .links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .links a {
            padding: 10px 20px;
            background-color: #0077cc;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .links a:hover {
            background-color: #005fa3;
        }

        .lang-switch {
            margin-top: 20px;
        }

        .lang-switch a {
            margin: 0 8px;
            text-decoration: none;
            color: #0077cc;
            font-weight: bold;
        }

        .lang-switch a:hover {
            text-decoration: underline;
        }
        .link-button {
            padding: 10px 20px;
            background-color: #0077cc;
            color: white;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font: inherit;
        }

        .link-button:hover {
            background-color: #005fa3;
        }
    </style>
</head>
<body>
    <div class="container">

        <h1>{{ __('messages.welcome') }}</h1>

    <div class="links">
        <a href="{{ route('recipes.all') }}">{{ __('messages.add_recipe') }}</a>

        @guest
            <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
            <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
        @else
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="link-button">
                    {{ __('messages.logout') }}
                </button>
            </form>
        @endguest
    </div>

        <div class="lang-switch">
            <a href="{{ route('lang.switch', 'lv') }}">LV</a> | 
            <a href="{{ route('lang.switch', 'en') }}">EN</a>
        </div>
    </div>
</body>
</html>
