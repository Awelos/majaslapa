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
    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            return redirect()->back()->with('error', 'Nav atļaujas dzēst šo komentāru!');
        }

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Komentārs veiksmīgi izdzēsts!');
    }


}
