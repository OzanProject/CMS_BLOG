<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Article::with(['category', 'user']);

        if (auth()->user()->role != 1) {
            $query->where('user_id', auth()->id());
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Sort by Views (Highest first), then by Date (Newest first)
        $articles = $query->orderBy('views', 'desc')->latest()->paginate(10)->withQueryString();
                            
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.articles.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:2048', // Max 2MB
        ]);

        $data = $request->except('featured_image');
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        
        // Handle Image Upload
        if ($request->hasFile('featured_image')) {
            $path = $request->file('featured_image')->store('articles', 'public');
            $data['featured_image'] = $path;
        }
        
        // Handle Published Date
        // Handle Published Date
        if ($request->status === 'published' && empty($request->published_at)) {
            $data['published_at'] = now();
        }

        // Handle Booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if (auth()->user()->role != 1 && $article->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $categories = Category::all();
        return view('admin.articles.form', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'status' => 'required|in:draft,published,archived',
            'featured_image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('featured_image');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $path = $request->file('featured_image')->store('articles', 'public');
            $data['featured_image'] = $path;
        }
        
        if ($request->status === 'published' && empty($article->published_at)) {
            $data['published_at'] = now();
        }

        // Handle Booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if (auth()->user()->role != 1 && $article->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }
        
        $article->delete();
        return redirect()->back()->with('success', 'Article deleted successfully!');
    }

    /**
     * Remove multiple resources from storage.
     */
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:articles,id',
        ]);

        foreach ($request->ids as $id) {
            $article = Article::find($id);
            if ($article) {
                if (auth()->user()->role != 1 && $article->user_id !== auth()->id()) {
                    continue; // Skip if unauthorized
                }
                
                if ($article->featured_image) {
                    Storage::disk('public')->delete($article->featured_image);
                }
                $article->delete();
            }
        }

        return redirect()->back()->with('success', 'Selected articles deleted successfully!');
    }

    /**
     * Handle Image Upload for CKEditor.
     */
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $path = $request->file('upload')->store('media', 'public');
            $url = asset('storage/' . $path);
            
            return response()->json([
                'url' => $url
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
