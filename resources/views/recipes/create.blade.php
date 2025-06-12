@extends('layouts.app')

@section('styles')
<style>
.container {
    max-width: 600px;
    margin: 30px auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    font-family: Arial, sans-serif;
}

h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
}

form > div {
    margin-bottom: 20px;
}

label {
    display: block;
    font-weight: 600;
    margin-bottom: 6px;
    color: #444;
}

input[type="text"],
textarea,
select,
input[type="file"] {
    width: 100%;
    padding: 8px 10px;
    font-size: 14px;
    border: 1.5px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

input[type="text"]:focus,
textarea:focus,
select:focus,
input[type="file"]:focus {
    border-color: #007bff;
    outline: none;
}

textarea {
    min-height: 100px;
    resize: vertical;
}

.form-group {
    margin-bottom: 20px;
}

button[type="submit"] {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 12px 25px;
    font-size: 16px;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}

input[type="checkbox"] {
    margin-right: 8px;
    transform: scale(1.1);
}

label > input[type="checkbox"] {
    vertical-align: middle;
}
</style>
@endsection

@section('content')
<div class="container">
    <h2>{{ __('messages.add_new_recipe') }}</h2>

    <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
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
            <label>{{ __('messages.recipe_tags') }}:</label><br>
            @foreach ($tags as $tag)
                <label>
                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                    {{ __('tags.' . $tag->id) }}
                </label><br>
            @endforeach
        </div>

        <div class="form-group">
            <label for="image">{{ __('messages.upload_image') }}</label>
            <input type="file" class="form-control" name="image" id="image" accept="image/*">
        </div>

        <button type="submit">{{ __('messages.save') }}</button>
    </form>
</div>
@endsection