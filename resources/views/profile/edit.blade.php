@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ __('messages.my_profile') }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Update Profile Form --}}
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="name">{{ __('messages.name') }}</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="email">{{ __('messages.email') }}</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control">
        </div>

        <div class="mb-3">
            <label for="password">{{ __('messages.new_password') }} ({{ __('messages.optional') }})</label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="password_confirmation">{{ __('messages.confirm_password') }}</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
    </form>

    <hr>

    {{-- Delete Profile Form --}}
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div class="mb-3">
            <label for="password">{{ __('messages.confirm_password_to_delete') }}</label>
            <input id="password" type="password" name="password" required class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-danger mt-3">
            {{ __('messages.delete_profile') }}
        </button>
    </form>
</div>
@endsection
