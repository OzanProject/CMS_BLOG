<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\FrontendController::class, 'index'])->name('home');

// Dynamic ads.txt
Route::get('/ads.txt', function () {
    $content = \App\Models\Configuration::where('key', 'ads_txt_content')->value('value');
    return response($content ?? '', 200)->header('Content-Type', 'text/plain');
});

Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/debug-comments', function() {
    return [
        'pending' => \App\Models\Comment::where('status', 'pending')->count(),
        'total' => \App\Models\Comment::count(),
        'latest_pending' => \App\Models\Comment::where('status', 'pending')->latest()->take(3)->get()
    ];
});
Route::get('/robots.txt', [\App\Http\Controllers\SitemapController::class, 'robots'])->name('robots');
Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Shared Routes (Admin & Writer - Role 1 & 2)
    Route::middleware(['role:1,2'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        // Route::get('/dashboard', ...) is already defined outside, keep it there or move here if needed.

        // Article Management
        Route::post('articles-bulk-delete', [\App\Http\Controllers\Admin\ArticleController::class, 'bulkDestroy'])->name('articles.bulk-destroy');
        Route::post('articles/upload-image', [\App\Http\Controllers\Admin\ArticleController::class, 'uploadImage'])->name('articles.upload-image');
        Route::resource('articles', \App\Http\Controllers\Admin\ArticleController::class);
        
        // Comment Management
        Route::get('comments/count', [\App\Http\Controllers\Admin\CommentController::class, 'count'])->name('comments.count');
        Route::resource('comments', \App\Http\Controllers\Admin\CommentController::class)->only(['index', 'update', 'destroy']);
    });

    // Admin Only Routes (Role 1)
    Route::middleware(['role:1'])->prefix('admin')->name('admin.')->group(function () {
        // Categories
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        
        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::patch('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
        
        // Site Settings
        Route::get('settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
        
        // Tasks
        Route::resource('tasks', \App\Http\Controllers\Admin\TaskController::class)->only(['store', 'update', 'destroy']);

        // Pages
        Route::resource('pages', \App\Http\Controllers\Admin\PageController::class);

        // Messages (Inbox)
        Route::resource('messages', \App\Http\Controllers\Admin\MessageController::class)->only(['index', 'show', 'destroy']);

        // Subscribers (Newsletter)
        // Subscribers (Newsletter)
        Route::get('subscribers/compose', [\App\Http\Controllers\Admin\SubscriberController::class, 'compose'])->name('subscribers.compose');
        Route::post('subscribers/send', [\App\Http\Controllers\Admin\SubscriberController::class, 'send'])->name('subscribers.send');
        Route::resource('subscribers', \App\Http\Controllers\Admin\SubscriberController::class)->only(['index', 'destroy']);

        // Backups (Database)
        Route::get('backups', [\App\Http\Controllers\Admin\BackupController::class, 'index'])->name('backups.index');
        Route::post('backups', [\App\Http\Controllers\Admin\BackupController::class, 'store'])->name('backups.store');
        Route::post('backups/restore', [\App\Http\Controllers\Admin\BackupController::class, 'restore'])->name('backups.restore');
        Route::post('backups/reset', [\App\Http\Controllers\Admin\BackupController::class, 'reset'])->name('backups.reset');
    });
});

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('switch-language');

// Contact Form
Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');
Route::post('/subscribe', [\App\Http\Controllers\NewsletterController::class, 'store'])->name('newsletter.subscribe');

// Public Pages Route
Route::get('/p/{slug}', [App\Http\Controllers\PublicPageController::class, 'show'])->name('page.show');
Route::get('/search', [App\Http\Controllers\FrontendController::class, 'search'])->name('search');
Route::get('/category', [App\Http\Controllers\FrontendController::class, 'allCategories'])->name('category.index');
Route::get('/category/{slug}', [App\Http\Controllers\FrontendController::class, 'showCategory'])->name('category.show');
Route::get('/article', [App\Http\Controllers\FrontendController::class, 'articles'])->name('article.index'); // Fixed: Route for /article
Route::get('/articles', [App\Http\Controllers\FrontendController::class, 'articles']); // Alias
Route::get('/article/{slug}', [App\Http\Controllers\FrontendController::class, 'showArticle'])->name('article.show');
Route::post('/article/{slug}/comment', [App\Http\Controllers\FrontendController::class, 'storeComment'])->name('article.comment');
Route::get('/author/{username}', [App\Http\Controllers\FrontendController::class, 'showAuthor'])->name('author.show');
Route::get('/lang/{locale}', [App\Http\Controllers\FrontendController::class, 'switchLanguage'])->name('lang.switch');

require __DIR__.'/auth.php';
