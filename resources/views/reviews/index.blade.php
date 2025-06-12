@extends('layouts.app')

@section('content')
<style>
    .review-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        font-family: Arial, sans-serif;
    }
    .review-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }
    .review-box {
        border-bottom: 1px solid #eee;
        padding-bottom: 15px;
        margin-bottom: 15px;
    }
    .review-time {
        font-size: 12px;
        color: #777;
    }
    .form-textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border-radius: 6px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        resize: vertical;
    }
    .form-button {
        background-color: #007BFF;
        color: white;
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
    }
    .form-button:hover {
        background-color: #0056b3;
    }
</style>

<div class="review-container">
    <div class="review-title">{{ __('messages.user_reviews') }}</div>

    @foreach ($reviews as $review)
        <div class="review-box">
            <p>{{ $review->content }}</p>
            <div class="review-time">{{ $review->created_at->diffForHumans() }}</div>
        </div>
    @endforeach

    <form method="POST" action="{{ route('reviews.store') }}">
        @csrf
        <textarea name="content" class="form-textarea" rows="4" placeholder="{{ __('messages.write_review_placeholder') }}"></textarea>
        <button type="submit" class="form-button">
            {{ __('messages.submit_review') }}
        </button>
    </form>
</div>
@endsection
