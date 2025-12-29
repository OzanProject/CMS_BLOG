<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache stats for 5 minutes to reduce DB load
        $stats = Cache::remember('admin_dashboard_stats', 5 * 60, function () {
            return [
                'total_articles' => Article::count(),
                'published_articles' => Article::where('status', 'published')->count(),
                'total_categories' => Category::count(),
                'total_comments' => Comment::count(),
                'pending_comments' => Comment::where('status', 'pending')->count(),
                'total_users' => User::count(),
            ];
        });

        $latest_articles = Article::with('user', 'category')->latest()->take(5)->get();
        $recent_comments = Comment::with('article')->latest()->take(5)->get();
        $tasks = \App\Models\Task::latest()->get();

        return view('admin.dashboard', compact('stats', 'latest_articles', 'recent_comments', 'tasks'));
    }
}
