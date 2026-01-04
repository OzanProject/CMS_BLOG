<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FrontendController extends Controller
{
    public function index()
    {
        // Cache Duration: Disabled temporarily for debugging
        $minutes = 0;

        // $data = Cache::remember('homepage_data', $minutes * 60, function () {
        $data = [
            'bannerArticles' => Article::with(['category', 'user'])
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->orderBy('is_featured', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get(),
                'trendingArticles' => Article::with(['category', 'user'])
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->orderBy('views', 'desc')
                    ->take(6)
                    ->get(),
                'latestArticles' => Article::with(['category', 'user'])
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->latest()
                    ->take(5)
                    ->get(),
                'gridArticles' => Article::with(['category', 'user'])
                    ->where('status', 'published')
                    ->where('published_at', '<=', now())
                    ->inRandomOrder()
                    ->take(4)
                    ->get(),
            'settings' => \App\Models\Configuration::pluck('value', 'key'),
        ];
        // });

        return view('frontend.home', $data);
    }

    public function showCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        
        $articles = Article::with(['user', 'category'])
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->paginate(12); // Grid pagination

        $recentArticles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(5)
            ->get();

        $settings = \App\Models\Configuration::pluck('value', 'key');

        return view('frontend.categories.show', compact('category', 'articles', 'recentArticles', 'settings'));
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        
        $articles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(12);

        $recentArticles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(5)
            ->get();

        $settings = \App\Models\Configuration::pluck('value', 'key');

        return view('frontend.search.index', compact('articles', 'recentArticles', 'settings', 'query'));
    }

    public function showArticle($slug)
    {
        $article = Article::with(['user', 'category', 'comments' => function($q) {
            $q->where('status', 'approved')->whereNull('parent_id')->latest()->with('children');
        }])
            ->where('slug', $slug)
            ->where('status', 'published')
            // Don't filter 'show' by date? Or should we?
            // Usually Scheduled post should result in 404.
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Increment views
        $article->increment('views');

        $recentArticles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(5)
            ->get();

        $settings = \App\Models\Configuration::pluck('value', 'key');

        // Fetch Related Articles (Same Category, Exclude Current)
        $relatedArticles = Article::where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(3) // Show 3 related articles
            ->get();

        return view('frontend.articles.show', compact('article', 'recentArticles', 'relatedArticles', 'settings'));
    }

    public function storeComment(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'body' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
            'website_catch' => 'nullable|string', // Honeypot validation
        ]);

        // Verify ReCaptcha
        if (config('services.recaptcha.secret_key')) {
            /** @var \Illuminate\Http\Client\Response $response */
             $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret_key'),
                'response' => $request->input('g-recaptcha-response'),
                'remoteip' => $request->ip(),
            ]);

            if (!$response->successful()) {
                return back()->withInput()->withErrors(['g-recaptcha-response' => 'ReCaptcha Connection Failed.']);
            }

            $body = $response->json();

            // v3 Verification (Success + Score Check)
            if (!($body['success'] ?? false) || ($body['score'] ?? 0) < 0.5) {
                return back()->withInput()->withErrors(['g-recaptcha-response' => 'Spam detected. Please try again later.']);
            }
        }

        // Honeypot Trap
        if ($request->filled('website_catch')) {
            return back()->with('success', 'Your comment has been posted!'); // Fake success
        }

        $article->comments()->create([
            'user_id' => auth()->id(), // Null if guest
            'name' => $request->name,
            'email' => $request->email,
            'body' => $request->body,
            'status' => 'pending', // Default to pending for moderation
            'parent_id' => $request->parent_id,
        ]);

        return back()->with('success', 'Your comment has been posted!');
    }

    public function showAuthor($username)
    {
        // Find user by slugified name since we don't have a username column
        $user = \App\Models\User::all()->first(function($u) use ($username) {
            return \Illuminate\Support\Str::slug($u->name) === $username;
        });
        
        if (!$user) {
            abort(404);
        }
        
        $articles = Article::with(['category'])
            ->where('user_id', $user->id)
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->paginate(12);

        $recentArticles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(5)
            ->get();

        $settings = \App\Models\Configuration::pluck('value', 'key');

        return view('frontend.authors.show', compact('user', 'articles', 'recentArticles', 'settings'));
    }

    public function switchLanguage($locale)
    {
        if (in_array($locale, ['en', 'id'])) {
            session(['locale' => $locale]);
        }
        return back();
    }

    public function allCategories()
    {
        $categories = Category::withCount('articles')->orderBy('name', 'asc')->get();
        $settings = \App\Models\Configuration::pluck('value', 'key');
        return view('frontend.categories.index', compact('categories', 'settings'));
    }

    public function articles()
    {
        $articles = Article::with(['user', 'category'])
            ->where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->paginate(12);

        $recentArticles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->take(5)
            ->get();

        $settings = \App\Models\Configuration::pluck('value', 'key');

        return view('frontend.articles.index', compact('articles', 'recentArticles', 'settings'));
    }
}
