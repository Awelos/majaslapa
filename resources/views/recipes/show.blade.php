@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $recipe->title }}</h2>
    <p><strong>Sastāvdaļas:</strong> {{ $recipe->ingredients }}</p>
    <p><strong>Apraksts:</strong> {{ $recipe->description }}</p>

    <hr>

    {{-- Tagi --}}
    <h4>Tagi:</h4>
    @if ($recipe->tags->isNotEmpty())
        <ul>
            @foreach ($recipe->tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    @else
        <p>Nav pievienotu tagu.</p>
    @endif

    <hr>

    {{-- Komentāri --}}
    <h4>Pievienot komentāru:</h4>
    @auth
        <form action="{{ route('comments.store') }}" method="POST">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
            <div class="mb-3">
                <textarea name="body" class="form-control" rows="3" placeholder="Tavs komentārs..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Pievienot</button>
        </form>
    @else
        <p>Jums jāielogojas, lai pievienotu komentāru.</p>
    @endauth

    <hr>

    {{-- Esošie komentāri --}}
    <h4>Komentāri:</h4>
    @forelse($recipe->comments as $comment)
        <div class="mb-3">
            <strong>{{ $comment->user->name ?? 'Anonīms' }}:</strong>
            <p>{{ $comment->body }}</p>
            <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
        </div>
    @empty
        <p>Nav neviena komentāra.</p>
    @endforelse
</div>
@endsection
