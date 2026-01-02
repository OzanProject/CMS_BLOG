<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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
            'featured_image' => 'nullable|image|max:10240', // Max 10MB (Optimized to <100KB)
        ]);

        $data = $request->except('featured_image');
        $data['user_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        
        // Handle Image Upload with Optimization
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');
            $filename = 'articles/' . Str::random(40) . '.webp';
            
            // Optimization: Resize & Convert to WebP
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->scale(width: 1200); // Max width 1200px
            $encoded = $image->toWebp(quality: 80);
            
            Storage::disk('public')->put($filename, (string) $encoded);
            $data['featured_image'] = $filename;
        }
        
        // Handle Published Date
        if ($request->status === 'published') {
            if ($request->filled('published_at')) {
                try {
                    $data['published_at'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->published_at);
                } catch (\Exception $e) {
                    $data['published_at'] = now();
                }
            } else {
                $data['published_at'] = now();
            }
        }

        // Handle Booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');

        $article = Article::create($data);

        // Handle Tags
        if ($request->has('tags')) {
            $tagIds = [];
            $tags = explode(',', $request->tags);
            foreach ($tags as $tagName) {
                $tagName = trim($tagName);
                if ($tagName) {
                    $tag = \App\Models\Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $article->tags()->sync($tagIds);
        }

        Cache::forget('admin_dashboard_stats');
        Cache::forget('homepage_data');

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
            'featured_image' => 'nullable|image|max:10240',
        ]);

        $data = $request->except('featured_image');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $file = $request->file('featured_image');
            $filename = 'articles/' . Str::random(40) . '.webp';
            
            // Optimization
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->scale(width: 1200);
            $encoded = $image->toWebp(quality: 80);
            
            Storage::disk('public')->put($filename, (string) $encoded);
            $data['featured_image'] = $filename;
        }
        
        if ($request->status === 'published') {
            if ($request->filled('published_at')) {
                try {
                    $data['published_at'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $request->published_at);
                } catch (\Exception $e) {
                    // Keep old date if parsing fails, or update ??
                }
            } elseif (empty($article->published_at)) {
                $data['published_at'] = now();
            }
        }

        // Handle Booleans
        $data['is_featured'] = $request->has('is_featured');
        $data['is_trending'] = $request->has('is_trending');

        $article->update($data);

        // Handle Tags
        if ($request->has('tags')) {
            $tagIds = [];
            $tags = explode(',', $request->tags);
            foreach ($tags as $tagName) {
                $tagName = trim($tagName);
                if ($tagName) {
                    $tag = \App\Models\Tag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName]
                    );
                    $tagIds[] = $tag->id;
                }
            }
            $article->tags()->sync($tagIds);
        } else {
             // If tags input is empty/missing but present in request, sync to empty (remove all)
             // But we need to be careful if input is missing entirely vs empty string.
             // Usually for text input, it sends empty string.
             if($request->exists('tags')) {
                 $article->tags()->sync([]);
             }
        }

        Cache::forget('admin_dashboard_stats');
        Cache::forget('homepage_data');

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
        Cache::forget('admin_dashboard_stats');
        Cache::forget('homepage_data');
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
                Cache::forget('admin_dashboard_stats');
                Cache::forget('homepage_data');
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
            $file = $request->file('upload');
            $filename = 'media/' . Str::random(40) . '.webp';
            
            // Optimization
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image->scale(width: 1000); // Limit content image width
            $encoded = $image->toWebp(quality: 80);
            
            Storage::disk('public')->put($filename, (string) $encoded);
            
            $url = asset('storage/' . $filename);
            
            return response()->json([
                'url' => $url
            ]);
        }
        
        return response()->json(['error' => 'No file uploaded'], 400);
    }
}
