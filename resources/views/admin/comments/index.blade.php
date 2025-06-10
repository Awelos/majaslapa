@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('comments_management') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($comments->isEmpty())
        <p>{{ __('no_comments_found') }}</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('author') }}</th>
                    <th>{{ __('body') }}</th>
                    <th>{{ __('created_at') }}</th>
                    <th>{{ __('actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($comments as $comment)
                    <tr>
                        <td>{{ $comment->user->name ?? 'Anonīms' }}</td>
                        <td>{{ $comment->body }}</td>
                        <td>{{ $comment->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('{{ __('confirm_delete_comment') }}');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">{{ __('delete') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
