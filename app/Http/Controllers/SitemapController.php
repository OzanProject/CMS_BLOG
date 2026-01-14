<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\User;

class SitemapController extends Controller
{
    public function index()
    {
        $baseUrl = config('app.url');

        // Static Pages
        $urls = [
            ['loc' => route('home'), 'lastmod' => now()->toAtomString(), 'priority' => '1.0', 'changefreq' => 'daily'],
            ['loc' => route('search'), 'lastmod' => now()->toAtomString(), 'priority' => '0.8', 'changefreq' => 'weekly'],
        ];

        // Categories
        $categories = Category::all();
        foreach ($categories as $category) {
            $date = $category->updated_at ?? $category->created_at ?? now();
            $urls[] = [
                'loc' => route('category.show', $category->slug),
                'lastmod' => $date->toAtomString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        }

        // Articles (Posts)
        $articles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->get();
        foreach ($articles as $article) {
            $date = $article->updated_at ?? $article->published_at ?? $article->created_at ?? now();
            $urls[] = [
                'loc' => route('article.show', $article->slug),
                'lastmod' => $date->toAtomString(),
                'priority' => '0.9',
                'changefreq' => 'daily',
            ];
        }

        // Authors
        $authors = User::whereHas('articles', function($q) {
            $q->where('status', 'published')->where('published_at', '<=', now());
        })->get();
        foreach ($authors as $author) {
             // Assuming author route uses name/username logic from FrontendController
            $username = $author->username ?? \Illuminate\Support\Str::slug($author->name);
            $date = $author->updated_at ?? $author->created_at ?? now();
            
            $urls[] = [
                'loc' => route('author.show', $username),
                'lastmod' => $date->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        // Dynamic Pages (About, Contact, etc.)
        $pages = Page::where('status', 1)->get();
        foreach ($pages as $page) {
            $date = $page->updated_at ?? $page->created_at ?? now();
            $urls[] = [
                'loc' => route('page.show', $page->slug),
                'lastmod' => $date->toAtomString(),
                'priority' => '0.5',
                'changefreq' => 'monthly',
            ];
        }

        $content = view('sitemap.index', compact('urls'))->render();
        return response('<?xml version="1.0" encoding="UTF-8"?>' . $content)
            ->header('Content-Type', 'text/xml');
    }
    public function robots()
    {
        $content = "User-agent: *\n";
        $content .= "Disallow:\n";
        $content .= "Sitemap: https://ozanproject.site/sitemap.xml\n";
        
        return response($content, 200)->header('Content-Type', 'text/plain');
    }
}
