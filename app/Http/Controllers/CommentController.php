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
        $comment = Comment::create($validated);
        $comment->load('user');

        if ($request->ajax()) {
            return response()->json([
                'body' => $comment->body,
                'created_at' => $comment->created_at->toDateTimeString(),
                'user' => ['name' => $comment->user->name ?? 'Anonīms']
            ]);
        }

        return response()->json([
            'message' => 'Komentārs pievienots!',
            'body' => $comment->body,
            'created_at' => $comment->created_at,
            'user' => [
                'name' => $comment->user->name ?? 'Anonīms',
                ],
        ]);
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