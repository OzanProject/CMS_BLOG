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
            $urls[] = [
                'loc' => route('category.show', $category->slug),
                'lastmod' => $category->updated_at->toAtomString(),
                'priority' => '0.8',
                'changefreq' => 'weekly',
            ];
        }

        // Articles (Posts)
        // Articles (Posts)
        $articles = Article::where('status', 'published')
            ->where('published_at', '<=', now())
            ->latest()
            ->get();
        foreach ($articles as $article) {
            $urls[] = [
                'loc' => route('article.show', $article->slug),
                'lastmod' => $article->updated_at->toAtomString(),
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
             // Using Str::slug($author->name) as per existing showAuthor logic if username not present
            $username = $author->username ?? \Illuminate\Support\Str::slug($author->name);
            
            $urls[] = [
                'loc' => route('author.show', $username),
                'lastmod' => $author->updated_at->toAtomString(),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        // Dynamic Pages (About, Contact, etc.)
        $pages = Page::where('status', 1)->get();
        foreach ($pages as $page) {
            $urls[] = [
                'loc' => route('page.show', $page->slug),
                'lastmod' => $page->updated_at->toAtomString(),
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
