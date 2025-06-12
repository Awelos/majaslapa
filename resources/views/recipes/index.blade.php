@extends('layouts.app')

@section('styles')
<style>
    .recipe-card {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .recipe-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .recipe-card a {
        color: #2c3e50;
        font-size: 1.4rem;
        font-weight: 600;
        text-decoration: none;
    }

    .recipe-card a:hover {
        color: #f39c12;
    }

    .recipe-meta {
        font-size: 0.9rem;
        color: #666;
        margin-top: 10px;
    }

    .recipe-meta small {
        display: block;
    }

    .recipe-image {
        margin-top: 15px;
    }

    .recipe-image img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .add-recipe-link {
        display: inline-block;
        background-color: #28a745;
        color: #fff;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        margin-bottom: 25px;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .add-recipe-link:hover {
        background-color: #218838;
    }

    .button-green {
        background-color: #28a745;
        color: #fff;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        transition: background-color 0.3s;
    }

    .button-green:hover {
        background-color: #218838;
    }

    .tag-filter .form-check {
        margin-bottom: 10px;
    }

    .search-section {
        margin-bottom: 30px;
    }

    .recipe-tags span {
        background-color: #f0f0f0;
        padding: 4px 8px;
        margin-right: 6px;
        border-radius: 4px;
        font-size: 0.85rem;
        color: #444;
    }
</style>
@endsection

@section('content')
<div class="container">
    <h2 class="mb-4">
        {{ $personal ? __('messages.my_recipes') : __('messages.recipes') }}
    </h2>

    @if ($personal)
        <a href="{{ route('recipes.create') }}" class="add-recipe-link">
            {{ __('messages.add_new_recipe') }}
        </a>
    @endif

    <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end search-section">
        <div class="col-md-5">
            <label for="search" class="form-label">{{ __('messages.search') }}</label>
            <input type="text" name="search" id="search" class="form-control" placeholder="{{ __('messages.search_placeholder') }}" value="{{ request('search') }}">
        </div>

        <div class="col-md-5 tag-filter">
            <label class="form-label">{{ __('messages.filter_by_tag') }}</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach ($availableTags as $tag)
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            name="tags[]" 
                            value="{{ $tag->id }}"
                            id="tag-{{ $tag->id }}"
                            {{ in_array($tag->id, (array) request('tags', [])) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="tag-{{ $tag->id }}">
                            {{ __('tags.' . $tag->id) }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-2">
            <button type="submit" class="button-green w-100">
                {{ __('messages.search') }}
            </button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($recipes->isEmpty())
        <p>{{ __('messages.no_recipes') }}</p>
    @else
        <ul class="list-unstyled">
            @foreach ($recipes as $recipe)
                <li class="recipe-card">
                    <a href="{{ route('recipes.show', $recipe) }}">
                        {{ $recipe->title }}
                    </a>

                    @if ($recipe->image)
                        <div class="recipe-image">
                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}">
                        </div>
                    @endif

                    <div class="recipe-meta">
                        <small>{{ __('messages.created_at') }}: {{ $recipe->created_at->format('Y-m-d H:i') }}</small>
                        <small>{{ __('messages.author') }}: {{ $recipe->user->name ?? __('messages.unknown') }}</small>
                    </div>

                    @if ($recipe->tags->isNotEmpty())
                        <div class="recipe-tags mt-2">
                            {{ __('messages.tags') }}:
                            @foreach ($recipe->tags as $tag)
                                <span>{{ __('tags.' . $tag->id) }}</span>
                            @endforeach
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        <div class="mt-4">
            {{ $recipes->withQueryString()->links() }}
        </div>
    @endif

</div>
@endsection
