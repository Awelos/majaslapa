<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentNotification;

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
        $comment->load(['user', 'recipe.user']);

        $recipeAuthor = $comment->recipe->user;

        if ($recipeAuthor && $recipeAuthor->email !== Auth::user()->email) {
            Mail::to($recipeAuthor->email)->send(new CommentNotification($comment));
        }

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'comment_created',
            'model_type' => Comment::class,
            'model_id' => $comment->id,
            'old_values' => null,
            'new_values' => [
                'recipe_id' => $comment->recipe_id,
                'body' => $comment->body,
            ],
        ]);

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

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'comment_deleted',
            'model_type' => Comment::class,
            'model_id' => $comment->id,
            'old_values' => [
                'recipe_id' => $comment->recipe_id,
                'body' => $comment->body,
            ],
            'new_values' => null,
        ]);

        $comment->delete();

        return redirect()->route('admin.comments.index')->with('success', 'Komentārs veiksmīgi izdzēsts!');
    }
}
