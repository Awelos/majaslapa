@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('messages.recipes') }}</h2>

    <a href="{{ route('recipes.create') }}">{{ __('messages.add_new_recipe') }}</a>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if($recipes->isEmpty())
        <p>{{ __('messages.no_recipes') }}</p>
    @else
        <ul>
            @foreach($recipes as $recipe)
                <li>
                    <a href="{{ route('recipes.show', ['recipe' => $recipe]) }}">
                        {{ $recipe->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
