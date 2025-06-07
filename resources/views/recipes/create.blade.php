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
        <div>
            <label>Kategorija:</label>
            <select name="category_id" required>
                <option value="">-- Izvēlies kategoriju --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Saglabāt</button>
    </form>
</div>
@endsection
