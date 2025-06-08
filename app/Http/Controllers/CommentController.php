<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipe_id' => 'required|exists:recipes,id',
            'body' => 'required|string',
        ]);

        $validated['user_id'] = Auth::id();

        Comment::create($validated);

        return redirect()->back()->with('success', 'Komentārs pievienots!');
    }
}
