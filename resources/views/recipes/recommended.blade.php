@extends('layouts.app')

@section('content')
    <style>
        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        h1 {
            font-size: 2em;
            margin-bottom: 20px;
            color: #333;
        }

        .weather-info {
            background-color: #e0f2fe;
            border: 1px solid #90cdf4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            color: #0c4a6e;
        }

        .recipe-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .recipe-item {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: box-shadow 0.3s ease;
        }

        .recipe-item:hover {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .recipe-item h3 {
            font-size: 1.25em;
            color: #222;
            margin-bottom: 10px;
        }

        .recipe-item p {
            color: #555;
            margin-bottom: 15px;
        }

        .recipe-item a {
            align-self: flex-start;
            text-decoration: none;
            background-color: #10b981;
            color: #fff;
            padding: 8px 14px;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .recipe-item a:hover {
            background-color: #059669;
        }

        .no-recipes {
            text-align: center;
            color: #666;
            font-size: 1.1em;
        }
    </style>

    <div class="container">
        <h1>{{ __('messages.recommended_recipes') }}</h1>

        <div class="weather-info">
            <p>{{ __('messages.current_weather') }}: <strong>{{ $weather['weather'][0]['main'] }}</strong> ({{ $weather['main']['temp'] }}°C)</p>
        </div>

        @if($recipes->isEmpty())
            <p class="no-recipes">{{ __('messages.no_recipes_for_weather') }}</p>
        @else
            <div class="recipe-list">
                @foreach($recipes as $recipe)
                    <div class="recipe-item">
                        <h3>{{ $recipe->title }}</h3>
                        <p>{{ Str::limit($recipe->description, 100) }}</p>
                        <a href="{{ route('recipes.show', $recipe->id) }}">{{ __('messages.view_recipe') }}</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
