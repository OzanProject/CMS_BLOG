<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use App\Models\Category;
use App\Models\Article;

class FrontendViewComposer
{
    public function compose(View $view)
    {
        // Get random or popular categories for tags
        $tags = Category::withCount('articles')
            ->having('articles_count', '>', 0)
            ->inRandomOrder()
            ->take(5)
            ->get();

        // Get popular articles based on views
        $popularArticles = Article::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        $view->with('footerTags', $tags);
        $view->with('footerPopularArticles', $popularArticles);
    }
}
