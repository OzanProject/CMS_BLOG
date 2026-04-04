<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        $settings = \App\Models\Configuration::pluck('value', 'key');
        return view('admin.themes.index', compact('themes', 'settings'));
    }

    public function activate(Theme $theme)
    {
        // Deactivate all
        Theme::where('is_active', true)->update(['is_active' => false]);
        
        // Activate current
        $theme->update(['is_active' => true]);
        
        // Clear view cache to be sure (optional but good)
        \Illuminate\Support\Facades\Artisan::call('view:clear');

        return back()->with('success', "Theme '{$theme->name}' activated successfully!");
    }
}
