<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\View::composer('layouts.frontend', \App\Http\View\Composers\FrontendViewComposer::class);

        try {
            // Share settings global variable if table exists
            if (\Illuminate\Support\Facades\Schema::hasTable('configurations')) {
                $settings = \App\Models\Configuration::pluck('value', 'key');
                \Illuminate\Support\Facades\View::share('settings', $settings);
            }

            // Compose Navbar with Comment Notifications
            \Illuminate\Support\Facades\View::composer('layouts.partials.navbar', function ($view) {
                if (\Illuminate\Support\Facades\Schema::hasTable('comments')) {
                     $unreadComments = \App\Models\Comment::where('status', 'pending')->latest()->take(3)->get();
                     $unreadCommentsCount = \App\Models\Comment::where('status', 'pending')->count();
                     $view->with('navbarComments', $unreadComments);
                     $view->with('navbarCommentsCount', $unreadCommentsCount);
                     $view->with('navbarCommentsCount', $unreadCommentsCount);
                }
            });

            // Compose Sidebar with Unread Messages Count
            \Illuminate\Support\Facades\View::composer('layouts.partials.sidebar', function ($view) {
                if (\Illuminate\Support\Facades\Schema::hasTable('messages')) {
                     $unreadMessagesCount = \App\Models\Message::where('is_read', false)->count();
                     $view->with('unreadMessagesCount', $unreadMessagesCount);
                }
            });
        } catch (\Exception $e) {
            // Fallback during migrations (do nothing)
        }
    }
}
