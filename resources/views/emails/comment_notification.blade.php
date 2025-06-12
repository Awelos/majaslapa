<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Jauns komentārs uz jūsu recepti</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            color: #333;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
        blockquote {
            font-style: italic;
            color: #555;
            border-left: 4px solid #ccc;
            margin-left: 0;
            padding-left: 10px;
        }
        a {
            color: #1a73e8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sveiki, {{ $comment->recipe->user->name }}!</h2>

        <p>Jūsu receptei <strong>"{{ $comment->recipe->title }}"</strong> ir pievienots jauns komentārs:</p>

        <blockquote>
            "{{ $comment->body }}"
        </blockquote>

        <p>Autors: <strong>{{ $comment->user->name ?? 'Anonīms' }}</strong></p>

        <p>
            Apskatīt recepti: 
            <a href="{{ route('recipes.show', $comment->recipe->id) }}">
                {{ route('recipes.show', $comment->recipe->id) }}
            </a>
        </p>

        <p>Ar cieņu,<br><strong>Recepšu meklētājs</strong></p>
    </div>
</body>
</html>
