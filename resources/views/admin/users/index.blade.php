@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ __('users_management') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($users->isEmpty())
        <p>{{ __('no_users_found') }}</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('name') }}</th>
                    <th>{{ __('email') }}</th>
                    <th>{{ __('actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('confirm_delete_user') }}');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('delete') }}</button>
                                </form>
                            @else
                                <span class="text-muted">{{ __('cannot_delete_self') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
