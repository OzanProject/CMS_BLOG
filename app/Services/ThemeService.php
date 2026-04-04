<?php

namespace App\Services;

use App\Models\Theme;
use Illuminate\Support\Facades\View;

class ThemeService
{
    protected $activeTheme;

    public function __construct()
    {
        // Cache or Singleton to avoid multiple DB hits
        $this->activeTheme = Theme::where('is_active', true)->first() ?? new Theme(['path' => 'default']);
    }

    public function getActiveThemePath()
    {
        return $this->activeTheme->path;
    }

    public function render($view, $data = [], $mergeData = [])
    {
        $themePath = $this->getActiveThemePath();
        
        // Try active theme first
        $fullPath = "themes.{$themePath}.{$view}";
        
        if (View::exists($fullPath)) {
            return view($fullPath, $data, $mergeData);
        }

        // Fallback to default
        $fallbackPath = "themes.default.{$view}";
        
        if (View::exists($fallbackPath)) {
            return view($fallbackPath, $data, $mergeData);
        }

        // Final fallback: standard view (not in themes folder)
        return view($view, $data, $mergeData);
    }
}
