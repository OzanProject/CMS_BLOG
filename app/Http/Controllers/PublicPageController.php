<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PublicPageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)->where('status', 1)->firstOrFail();
        
        $recentArticles = \App\Models\Article::where('status', 'published')->latest()->take(5)->get();
        $settings = \App\Models\Configuration::pluck('value', 'key');
        
        return view('frontend.pages.show', compact('page', 'recentArticles', 'settings'));
    }
}
