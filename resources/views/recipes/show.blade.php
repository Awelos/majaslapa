@extends('layouts.app')

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

@endsection
