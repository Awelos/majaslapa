@extends('layouts.app')

@section('content')
    <h1>{{ __('messages.recommended_recipes') }}</h1>

    <p>{{ __('messages.current_weather') }}: {{ $weather['weather'][0]['main'] }} ({{ $weather['main']['temp'] }}°C)</p>

    @if($recipes->isEmpty())
        <p>{{ __('messages.no_recipes_for_weather') }}</p>
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
@endsection
