@extends('layouts.app')

@section('content')
    <h1>{{ __('Recommended Recipes') }}</h1>

    <p>{{ __('Current Weather') }}: {{ $weather['weather'][0]['main'] }} ({{ $weather['main']['temp'] }}°C)</p>

    @if($recipes->isEmpty())
        <p>{{ __('No recipes found for current weather.') }}</p>
    @else
        <div class="recipe-list">
            @foreach($recipes as $recipe)
                <div class="recipe-item">
                    <h3>{{ $recipe->title }}</h3>
                    <p>{{ Str::limit($recipe->description, 100) }}</p>
                    <a href="{{ route('recipes.show', $recipe->id) }}">{{ __('View Recipe') }}</a>
                </div>
            @endforeach
        </div>
    @endif
@endsection
