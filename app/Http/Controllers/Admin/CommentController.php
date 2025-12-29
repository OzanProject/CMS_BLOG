<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Return pending comments count for navbar.
     */
    public function count()
    {
        $count = Comment::where('status', 'pending')->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Comment::query()->with(['article', 'user']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $comments = $query->latest()->paginate(10);
        
        // Counts for tabs
        $counts = [
            'all' => Comment::count(),
            'pending' => Comment::where('status', 'pending')->count(),
            'approved' => Comment::where('status', 'approved')->count(),
            'spam' => Comment::where('status', 'spam')->count(),
        ];

        return view('admin.comments.index', compact('comments', 'status', 'counts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,spam'
        ]);

        $comment->update(['status' => $request->status]);

        return back()->with('success', 'Comment status updated to ' . ucfirst($request->status));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted successfully');
    }
}
