@extends('layouts.app')

@section('styles')
<style>
.container {
    max-width: 900px;
    margin: 40px auto;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #333;
}

h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #2c3e50;
    font-weight: 700;
}

.alert {
    padding: 12px 20px;
    margin-bottom: 25px;
    border-radius: 5px;
    font-weight: 600;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

p {
    text-align: center;
    font-style: italic;
    color: #777;
}

.table {
    width: 100%;
    border-collapse: collapse;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.table thead {
    background-color: #3490dc;
    color: white;
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

.btn {
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
    border: none;
    transition: background-color 0.3s ease;
    display: inline-block;
}

.btn-danger {
    background-color: #e3342f;
    color: white;
}

.btn-danger:hover {
    background-color: #cc1f1a;
}

.text-muted {
    color: #999;
    font-style: italic;
    font-size: 14px;
}
</style>
@endsection

@section('content')
<div class="container">
    <h1>{{ __('messages.users_management') }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($users->isEmpty())
        <p>{{ __('messages.no_users_found') }}</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.email') }}</th>
                    <th>{{ __('messages.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('messages.confirm_delete_user') }}');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('messages.delete') }}</button>
                                </form>
                            @else
                                <span class="text-muted">{{ __('messages.cannot_delete_self') }}</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
