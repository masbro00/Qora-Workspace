<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // Menambahkan komentar baru ke sebuah Bug
    public function store(Request $request)
{
    $request->validate([
        'bug_id' => 'required|exists:bugs,id',
        'body' => 'required|string', // <-- Gunakan 'body'
    ]);

    $comment = Comment::create([
        'bug_id' => $request->bug_id,
        'user_id' => $request->user()->id,
        'body' => $request->body, // <-- Gunakan 'body'
    ]);

    $comment->load('user:id,name,email');

    return response()->json([
        'message' => 'Comment successfully added',
        'data' => $comment
    ], 201);
}

    // Menghapus komentar
    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Comment successfully deleted'
        ]);
    }
}