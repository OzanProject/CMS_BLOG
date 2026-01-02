<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Configuration::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            // Skip file inputs that are null
            if ($request->hasFile($key)) {
                continue;
            }
            
            Configuration::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle File Uploads
        $this->handleFileUpload($request, 'site_logo');
        $this->handleFileUpload($request, 'site_favicon');
        $this->handleFileUpload($request, 'ad_header_image');
        $this->handleFileUpload($request, 'ad_sidebar_image');

        return back()->with('success', 'Settings updated successfully.');
    }

    private function handleFileUpload(Request $request, $key)
    {
        if ($request->hasFile($key)) {
            $file = $request->file($key);
            $filename = 'settings/' . Str::random(40) . '.webp';
            
            // Optimization
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);

            // Resize logic
            if ($key === 'site_favicon') {
                $image->scale(width: 128); // Favicon size
            } else {
                $image->scale(width: 1200); // General limit
            }

            $encoded = $image->toWebp(quality: 85);
            Storage::disk('public')->put($filename, (string) $encoded);
            
            // Delete old file if exists
            $old = Configuration::where('key', $key)->value('value');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }

            Configuration::updateOrCreate(['key' => $key], ['value' => $filename]);
        }
    }
}
