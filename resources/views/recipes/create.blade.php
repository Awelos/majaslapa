@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Pievienot recepti</h2>
    <form action="{{ route('recipes.store') }}" method="POST">
        @csrf
        <div>
            <label>Nosaukums:</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label>Sastāvdaļas:</label>
            <textarea name="ingredients" required></textarea>
        </div>
        <div>
            <label>Apraksts:</label>
            <textarea name="description" required></textarea>
        </div>
        <button type="submit">Saglabāt</button>
    </form>
</div>
@endsection
