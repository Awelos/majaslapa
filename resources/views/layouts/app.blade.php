<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ __('messages.site_title') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fefefe;
            margin: 0;
            padding: 0;
            color: #34495e;
            line-height: 1.6;
        }
        header {
            background: linear-gradient(90deg, #3490dc 0%,rgb(31, 101, 158) 100%);
            padding: 20px 40px;
            color: #fff;
            box-shadow: 0 3px 8px rgba(167, 201, 87, 0.4);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            user-select: none;
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
            flex-shrink: 0;
        }
        nav {
            margin-left: 30px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 18px;
            flex-grow: 1;
        }
        nav a {
            color: #f0f3bd;
            text-decoration: none;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 6px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        nav a:hover,
        nav a:focus {
            background-color: #f0f3bd;
            color: #34495e;
            outline: none;
        }
        nav a.btn {
            background-color: #f08a5d;
            color: #fff !important;
            font-weight: 700;
            box-shadow: 0 4px 8px rgba(240, 138, 93, 0.4);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }
        nav a.btn:hover,
        nav a.btn:focus {
            background-color: #d8703f;
            box-shadow: 0 6px 12px rgba(216, 112, 63, 0.5);
            color: #fff !important;
            outline: none;
        }
        nav span {
            margin-left: auto;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
            font-weight: 600;
        }
        nav span a {
            background-color: rgba(240, 138, 93, 0.25);
            color: #f0f3bd;
            padding: 6px 12px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            white-space: nowrap;
            text-decoration: none;
        }
        nav span a:hover,
        nav span a:focus {
            background-color: #f0f3bd;
            color: #34495e;
            outline: none;
        }
        #logout-form {
            margin: 0;
        }
        #logout-form button {
            background: none;
            border: none;
            color: #f0f3bd;
            font-weight: 600;
            padding: 10px 16px;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        #logout-form button:hover,
        #logout-form button:focus {
            background-color: #f0f3bd;
            color: #34495e;
            outline: none;
        }
        main.py-4 {
            padding: 30px 40px;
            max-width: 900px;
            margin: 30px auto;
            background-color: #ffffff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            border-radius: 10px;
            min-height: 70vh;
        }
        @media (max-width: 600px) {
            header {
                flex-direction: column;
                align-items: flex-start;
            }
            nav {
                margin-left: 0;
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
                width: 100%;
            }
            nav span {
                align-items: flex-start;
                margin-left: 0;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <header>
        <h1>{{ __('messages.site_name') }}</h1>
        <nav>
            <a href="{{ url('/') }}">{{ __('messages.home') }}</a>
            <a href="{{ route('recipes.index') }}">{{ __('messages.my_recipes') }}</a>
            @auth
                <a href="{{ route('recipes.all') }}">{{ __('messages.all_recipes') }}</a>
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_panel') }}</a>
                @endif
                <a href="{{ route('profile.edit') }}">{{ __('messages.my_profile') }}</a>
                <a href="{{ route('reviews.index') }}">{{ __('messages.user_reviews') }}</a>
                <a href="{{ route('recipes.recommended') }}" class="btn btn-outline-success">
                    {{ __('messages.reccomended') }}
                </a>
                <span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">{{ __('messages.logout') }}</button>
                    </form>
                    <div>
                        <a href="{{ route('lang.switch', 'lv') }}">LV</a> | 
                        <a href="{{ route('lang.switch', 'en') }}">EN</a>
                    </div>
                </span>
            @endauth
            @guest
                <a href="{{ route('login') }}">{{ __('messages.login') }}</a>
                <a href="{{ route('register') }}">{{ __('messages.register') }}</a>
                <span>
                    <a href="{{ route('lang.switch', 'lv') }}">LV</a> | 
                    <a href="{{ route('lang.switch', 'en') }}">EN</a>
                </span>
            @endguest
        </nav>
    </header>
    <main class="py-4">
        @yield('content')
    </main>
</body>
</html>
