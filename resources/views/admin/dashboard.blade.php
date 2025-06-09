@extends('layouts.app')

@section('content')
    <h1>{{ __('messages.admin_dashboard') }}</h1>

    <ul>
        <li><a href="{{ route('admin.dashboard') }}">{{ __('messages.admin_panel') }}</a></li>
        <li><a href="{{ route('recipes.index') }}">{{ __('messages.recipes_management') }}</a></li>
        <li><a href="#">{{ __('messages.users') }}</a></li>
    </ul>
@endsection
