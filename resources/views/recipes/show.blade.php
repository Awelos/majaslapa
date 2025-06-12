@extends('layouts.app')

<style>
.container {
    max-width: 720px;
    margin: 2rem auto;
    padding: 1.5rem 2rem;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #222;
}

h2 {
    font-weight: 700;
    font-size: 2rem;
    margin-bottom: 1.2rem;
    color: #2c3e50;
    border-bottom: 2px solid #2980b9;
    padding-bottom: 0.3rem;
}

h4 {
    font-size: 1.4rem;
    margin-bottom: 1rem;
    color: #34495e;
    border-left: 5px solid #2980b9;
    padding-left: 0.75rem;
    font-weight: 600;
}

img.img-fluid {
    width: 100%;
    max-height: 320px;
    object-fit: cover;
    border-radius: 10px;
    box-shadow: 0 6px 12px rgba(41, 128, 185, 0.3);
    margin-bottom: 1.5rem;
    transition: transform 0.3s ease;
}

img.img-fluid:hover {
    transform: scale(1.03);
}

p {
    font-size: 1.1rem;
    line-height: 1.6;
    margin-bottom: 1rem;
    color: #444;
}

strong {
    color: #2980b9;
}

ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 1rem;
}

ul li {
    display: inline-block;
    background: #ecf0f1;
    color: #34495e;
    border-radius: 16px;
    padding: 0.35rem 0.9rem;
    margin: 0 0.4rem 0.4rem 0;
    font-weight: 600;
    font-size: 0.9rem;
    user-select: none;
    transition: background-color 0.25s ease;
}

ul li:hover {
    background-color: #2980b9;
    color: #fff;
    cursor: default;
}

hr {
    border: none;
    border-top: 1px solid #ddd;
    margin: 1.5rem 0;
}

.comment-item {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 0.8rem 1rem;
    margin-bottom: 1rem;
    box-shadow: 0 1px 4px rgba(0,0,0,0.05);
}

.comment-item strong {
    color: #2980b9;
    font-weight: 700;
}

.comment-item p {
    margin: 0.3rem 0 0.7rem;
}

.comment-item small {
    color: #999;
    font-size: 0.8rem;
}

a.btn-warning {
    display: inline-block;
    margin-bottom: 0.8rem;
}

form.d-inline button.btn-danger {
    display: inline-block;
}

.btn-warning, .btn-danger, .btn-primary {
    padding: 0.55rem 1.3rem;
    font-weight: 600;
    border-radius: 8px;
    border: none;
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    transition: background-color 0.25s ease, box-shadow 0.25s ease, transform 0.15s ease;
    cursor: pointer;
    user-select: none;
    display: inline-block;
    text-align: center;
    line-height: 1.3;
    color: #fff;
    text-decoration: none;
}

.btn-warning {
    background-color: #f39c12;
}

.btn-warning:hover, .btn-warning:focus {
    background-color: #d68910;
    box-shadow: 0 6px 12px rgba(243, 156, 18, 0.5);
    outline: none;
    transform: translateY(-2px);
}

.btn-danger {
    background-color: #e74c3c;
}

.btn-danger:hover, .btn-danger:focus {
    background-color: #c0392b;
    box-shadow: 0 6px 12px rgba(231, 76, 60, 0.5);
    outline: none;
    transform: translateY(-2px);
}

.btn-primary {
    background-color: #2980b9;
}

.btn-primary:hover, .btn-primary:focus {
    background-color: #21618c;
    box-shadow: 0 6px 12px rgba(41, 128, 185, 0.5);
    outline: none;
    transform: translateY(-2px);
}

.btn-warning:active,
.btn-danger:active,
.btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    transition: none;
}

@media (max-width: 576px) {
    .btn-warning, .btn-danger, .btn-primary {
        width: 100%;
        padding: 0.65rem 0;
    }
}
</style>

@section('content')
<div class="container">
    <h2>{{ $recipe->title }}</h2>

    {{-- Recipe Bilde --}}
    @if ($recipe->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->title }}" class="img-fluid rounded">
        </div>
    @endif

    <p><strong>{{ __('messages.recipe_ingredients') }}:</strong> {{ $recipe->ingredients }}</p>
    <p><strong>{{ __('messages.recipe_description') }}:</strong> {{ $recipe->description }}</p>

    <hr>

    {{-- Tagi --}}
    <h4>{{ __('messages.recipe_tags') }}:</h4>
    @if ($recipe->tags->isNotEmpty())
        <ul>
            @foreach ($recipe->tags as $tag)
                <li>{{ __('tags.' . $tag->id) }}</li>
            @endforeach
        </ul>
    @else
        <p>{{ __('messages.no_tags') }}</p>
    @endif

    <hr>

    @can('update', $recipe)
        <a href="{{ route('recipes.edit', $recipe) }}" class="btn btn-warning">{{ __('messages.edit') }}</a>
    @endcan

    @can('delete', $recipe)
        <form action="{{ route('recipes.destroy', $recipe) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                {{ __('messages.delete') }}
            </button>
        </form>
        <hr>
    @endcan

    {{-- Komentāru forma --}}
    <h4>{{ __('messages.add_comment') }}:</h4>
    @auth
        <form id="comment-form">
            @csrf
            <input type="hidden" name="recipe_id" value="{{ $recipe->id }}">
            <div class="mb-3">
                <textarea name="body" class="form-control" rows="3" placeholder="{{ __('messages.your_comment') }}" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('messages.submit') }}</button>
        </form>
        <div id="comment-success" style="color: green; display: none;">Komentārs pievienots!</div>
        <div id="comment-error" style="color: red; display: none;">Neizdevās pievienot komentāru.</div>
    @endauth

    <hr>

    {{-- Esošie komentāri --}}
    <h4>{{ __('messages.comments') }}</h4>
    <div id="comments-list">
        @forelse($recipe->comments as $comment)
            <div class="mb-3 comment-item">
                <strong>{{ $comment->user->name ?? 'Anonīms' }}:</strong>
                <p>{{ $comment->body }}</p>
                <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>

                @auth
                    @if(auth()->user()->is_admin)
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tiešām dzēst šo komentāru?')">
                                {{ __('messages.delete_comment') }}
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        @empty
            <p id="no-comments">{{ __('messages.no_comments') }}</p>
        @endforelse
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('comment-form');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const submitButton = form.querySelector('button[type="submit"]');
                submitButton.disabled = true;

                const formData = new FormData(form);

                fetch("{{ route('comments.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Failed to submit comment');
                    return response.json();
                })
                .then(data => {
                    const noComments = document.getElementById('no-comments');
                    if (noComments) noComments.remove();

                    const commentsList = document.getElementById('comments-list');
                    const newComment = document.createElement('div');
                    newComment.classList.add('mb-3', 'comment-item');
                    newComment.innerHTML = `
                        <strong>${data.user.name ?? 'Anonīms'}:</strong>
                        <p>${data.body}</p>
                        <small class="text-muted">${new Date(data.created_at).toLocaleString()}</small>
                    `;
                    commentsList.appendChild(newComment);

                    form.body.value = '';
                })
                .catch(error => {
                    console.error(error);
                    alert('Neizdevās pievienot komentāru.');
                })
                .finally(() => {
                    submitButton.disabled = false;
                });
            });
        }
    });
    </script>

</div>
@endsection
