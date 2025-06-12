@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Rediģēt recepti: {{ $recipe->title }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('recipes.update', $recipe) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nosaukums --}}
        <div class="mb-3">
            <label for="title" class="form-label">Nosaukums</label>
            <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $recipe->title) }}" required>
        </div>

        {{-- Sastāvdaļas --}}
        <div class="mb-3">
            <label for="ingredients" class="form-label">{{ __('messages.recipe_ingredients') }}</label>
            <textarea class="form-control" id="ingredients" name="ingredients" rows="3" required>{{ old('ingredients', $recipe->ingredients) }}</textarea>
        </div>

        {{-- Apraksts --}}
        <div class="mb-3">
            <label for="description" class="form-label">{{ __('messages.recipe_description') }}</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $recipe->description) }}</textarea>
        </div>

        {{-- Tagi kā checkbox --}}
        <div class="mb-3">
            <label class="form-label">{{ __('messages.recipe_tags') }}</label>
            <div>
                @foreach($allTags as $tag)
                    <div class="form-check">
                        <input 
                            class="form-check-input" 
                            type="checkbox" 
                            id="tag_{{ $tag->id }}" 
                            name="tags[]" 
                            value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tags', $recipe->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="tag_{{ $tag->id }}">
                            {{ $tag->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Attēls --}}
        <div class="mb-3">
            <label for="image" class="form-label">Attēls (ja vēlies mainīt)</label>
            <input class="form-control" type="file" id="image" name="image">
            @if ($recipe->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $recipe->image) }}" alt="Pašreizējais attēls" class="img-fluid rounded" style="max-width: 200px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Saglabāt izmaiņas</button>
        <a href="{{ route('recipes.show', $recipe) }}" class="btn btn-secondary">Atcelt</a>
    </form>
</div>
@endsection