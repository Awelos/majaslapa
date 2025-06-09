@extends('layouts.app')

@section('content')
<style>
    .recipe-list {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .recipe-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .recipe-item:hover {
        transform: translateY(-2px);
    }
    .recipe-item a {
        text-decoration: none;
        color: #333;
        font-size: 1.2rem;
        font-weight: bold;
    }
    .recipe-item small {
        display: block;
        color: #777;
        margin-top: 6px;
    }
    h2 {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h2>{{ __('messages.all_recipes') }}</h2>

    @if($recipes->isEmpty())
        <p>{{ __('messages.no_recipes') }}</p>
    @else
        <ul class="recipe-list">
            @foreach($recipes as $recipe)
                <li class="recipe-item">
                    <a href="{{ route('recipes.show', ['recipe' => $recipe->id]) }}">
                        {{ $recipe->title }}
                    </a>
                    <small>{{ __('messages.created_at') }}: {{ $recipe->created_at->format('Y-m-d H:i') }}</small>
                    <small>{{ __('messages.recipe_category') }}: {{ $recipe->category->name ?? '' }}</small>
                    <small>{{ __('messages.author') }}: {{ $recipe->user->name ?? __('messages.unknown') }}</small>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
