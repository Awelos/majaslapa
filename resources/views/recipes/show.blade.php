@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $recipe->title }}</h2>
    <p><strong>{{ __('messages.recipe_ingredients') }}:</strong> {{ $recipe->ingredients }}</p>
    <p><strong>{{ __('messages.recipe_description') }}:</strong> {{ $recipe->description }}</p>

    <hr>

    {{-- Tagi --}}
    <h4>{{ __('messages.recipe_tags') }}:</h4>
    @if ($recipe->tags->isNotEmpty())
        <ul>
            @foreach ($recipe->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    @else
        <p>{{ __('messages.no_tags') }}</p>
    @endif

    <hr>

    {{-- Komentāru forma --}}
    <h4>{{ __('messages.add_comment') }}:</h4>
    @auth
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
            <div class="mb-3">
                <textarea name="body" class="form-control" rows="3" placeholder="{{ __('messages.your_comment') }}" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
        </form>
    @else
        <p>{{ __('messages.login_to_comment') }}</p>
    @endauth

    <hr>

    {{-- Esošie komentāri --}}
    <h4>{{ __('messages.comments') }}:</h4>
    @forelse($recipe->comments as $comment)
        <div class="mb-3">
            <strong>{{ $comment->user->name ?? 'Anonīms' }}:</strong>
            <p>{{ $comment->body }}</p>
            <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
        </div>
    @empty
        <p>{{ __('messages.no_comments') }}</p>
    @endforelse
</div>
@endsection
