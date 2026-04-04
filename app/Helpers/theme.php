<?php

if (!function_exists('theme_view')) {
    /**
     * Helper to render theme views with fallback.
     */
    function theme_view($view, $data = [], $mergeData = [])
    {
        return app(\App\Services\ThemeService::class)->render($view, $data, $mergeData);
    }
}

if (!function_exists('active_theme')) {
    /**
     * Get active theme name.
     */
    function active_theme()
    {
        return app(\App\Services\ThemeService::class)->getActiveThemePath();
    }
}
