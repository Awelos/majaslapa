@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $recipe->title }}</h2>
    <p><strong>Sastāvdaļas:</strong> {{ $recipe->ingredients }}</p>
    <p><strong>Apraksts:</strong> {{ $recipe->description }}</p>
</div>
@endsection
