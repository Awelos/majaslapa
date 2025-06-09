@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('messages.add_new_recipe') }}</h2>

    <form action="{{ route('recipes.store') }}" method="POST">
        @csrf
        <div>
            <label>{{ __('messages.recipe_title') }}:</label>
            <input type="text" name="title" required>
        </div>

        <div>
            <label>{{ __('messages.recipe_ingredients') }}:</label>
            <textarea name="ingredients" required></textarea>
        </div>

        <div>
            <label>{{ __('messages.recipe_description') }}:</label>
            <textarea name="description" required></textarea>
        </div>

        <div>
            <label>{{ __('messages.recipe_category') }}:</label>
            <select name="category_id" required>
                <option value="">{{ __('messages.choose_category') }}</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label>{{ __('messages.recipe_tags') }}:</label><br>
            @foreach ($tags as $tag)
                <label>
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                    {{ $tag->name }}
                </label><br>
            @endforeach
        </div>

        <button type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection
