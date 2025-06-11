
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

    .add-recipe-link {
        display: inline-block;
        background-color: #28a745;
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        margin-bottom: 16px;
        transition: background-color 0.2s;
    }

    .add-recipe-link:hover {
        background-color: #218838;
    }

    h2 {
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h2>
        @if ($personal)
            {{ __('messages.my_recipes') }}
        @else
            {{ __('messages.recipes') }}
        @endif
    </h2>

    @if ($personal)
        <a href="{{ route('recipes.create') }}" class="add-recipe-link">
            {{ __('messages.add_new_recipe') }}
        </a>
    @endif

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if ($recipes->isEmpty())
        <p>{{ __('messages.no_recipes') }}</p>
    @else
    @foreach ($recipes as $recipe)
        <li class="recipe-item">
            <a href="{{ route('recipes.show', $recipe) }}">
                {{ $recipe->title }}
            </a>

            @if ($recipe->image)
                <div>
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" style="max-width: 200px;">
                </div>
            @endif

            <small>{{ __('messages.created_at') }}: {{ $recipe->created_at->format('Y-m-d H:i') }}</small>
        </li>
    @endforeach
        </ul>
    @endif
</div>
@endsection