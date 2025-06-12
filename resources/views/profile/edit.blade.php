@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: auto;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-size: 1.25rem;
        font-weight: 600;
        padding: 1rem 1.5rem;
    }

    .form-label {
        font-weight: 500;
    }

    .btn-custom-save {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-custom-save:hover {
        background-color: #218838;
    }

    .btn-custom-delete {
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn-custom-delete:hover {
        background-color: #c82333;
    }

    h2 {
        font-weight: 600;
        margin-bottom: 2rem;
    }

    .alert-success {
        border-radius: 10px;
    }
</style>

<div class="container profile-container py-5">
    <h2>{{ __('messages.my_profile') }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Update Profile Form --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('messages.email') }}</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.new_password') }} ({{ __('messages.optional') }})</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('messages.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-custom-save">
                    {{ __('messages.save') }}
                </button>
            </form>
        </div>
    </div>

    {{-- Delete Profile Form --}}
    <div class="card border-danger">
        <div class="card-header bg-danger text-white">
            {{ __('messages.delete_profile') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')

                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('messages.confirm_password_to_delete') }}</label>
                    <input id="password" type="password" name="password" required class="form-control">
                </div>

                <button type="submit" class="btn btn-custom-delete">
                    {{ __('messages.delete_profile') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
