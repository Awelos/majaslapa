@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Manas receptes</h2>

    <a href="{{ route('recipes.create') }}">Pievienot jaunu recepti</a>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if($recipes->isEmpty())
        <p>Tev vēl nav nevienas receptes.</p>
    @else
        <ul>
            @foreach($recipes as $recipe)
                <li>
                    <a href="{{ route('recipes.show', $recipe) }}">
                        {{ $recipe->title }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
