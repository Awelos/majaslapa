@extends('layouts.app')

@section('styles')
<style>
h1 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 30px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

ul {
    max-width: 400px;
    margin: 0 auto;
    padding: 0;
    list-style: none;
}

ul li {
    margin-bottom: 15px;
}

ul li a {
    display: block;
    background-color: #3490dc;
    color: white;
    text-decoration: none;
    padding: 12px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 18px;
    transition: background-color 0.3s ease;
    box-shadow: 0 3px 6px rgba(52, 144, 220, 0.4);
}

ul li a:hover {
    background-color: #2779bd;
    box-shadow: 0 5px 10px rgba(39, 121, 189, 0.6);
}
</style>
@endsection

@section('content')
    <h1>{{ __('messages.admin_dashboard') }}</h1>

    <ul>
        <li><a href="{{ url('/all-recipes') }}">{{ __('messages.recipes_management') }}</a></li>
        <li><a href="{{ route('admin.users.index') }}">{{ __('messages.users') }}</a></li>
    </ul>
@endsection