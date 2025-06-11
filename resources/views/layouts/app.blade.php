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
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            padding: 15px 30px;
            color: #ecf0f1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        header h1 {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        nav {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 15px;
        }

        nav a {
            color: #ecf0f1;
            text-decoration: none;
            font-weight: 500;
            padding: 8px 14px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav a:hover,
        nav a:focus {
            background-color: #34495e;
            color: #f39c12;
        }

        nav span {
            margin-left: auto;
            font-weight: 600;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        nav span a {
            color: #ecf0f1;
            font-weight: 600;
            padding: 5px 8px;
            border-radius: 3px;
            background-color: #34495e;
            transition: background-color 0.3s;
            white-space: nowrap;
        }

        nav span a:hover {
            background-color: #f39c12;
            color: #2c3e50;
        }

        main.py-4 {
            padding: 20px 30px;
            max-width: 900px;
            margin: 0 auto;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border-radius: 8px;
            min-height: 70vh;
        }

        /* logout poga kā saite */
        #logout-form {
            margin: 0;
        }
        #logout-form button {
            background: none;
            border: none;
            color: #ecf0f1;
            font-weight: 500;
            padding: 8px 14px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        #logout-form button:hover,
        #logout-form button:focus {
            background-color: #34495e;
            color: #f39c12;
            outline: none;
        }
    </style>
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

                <a href="{{ route('profile.edit') }}">Mans profils</a>
                <a href="{{ route('reviews.index') }}">{{ __('User Reviews') }}</a>
                <a href="{{ route('recipes.recommended') }}" class="btn btn-outline-success">
                    {{ __('Recommended for You') }}
                </a>

                <span>
                    <!-- logout poga virs valodu izvēles -->
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
