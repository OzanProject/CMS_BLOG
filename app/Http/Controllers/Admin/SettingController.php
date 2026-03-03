<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SettingController extends Controller
{
    /**
     * Whitelist of keys yang diizinkan diubah melalui settings form.
     * Ini mencegah penyerang menyimpan key sembarangan ke database.
     */
    protected array $allowedKeys = [
        'site_name',
        'site_description',
        'site_copyright',
        'site_logo',
        'site_favicon',
        'social_facebook',
        'social_twitter',
        'social_youtube',
        'social_instagram',
        'social_google',
        'google_analytics_id',
        'google_verification_code',
        'ads_txt_content',
        'ad_header_script',
        'ad_header_url',
        'ad_header_image',
        'ad_sidebar_script',
        'ad_sidebar_url',
        'ad_sidebar_image',
        'ad_in_article_script',
        'ad_in_article_url',
        'ad_in_article_image',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'contact_address',
        'contact_phone',
        'contact_email',
        'about_text',
        'maintenance_mode',
        'maintenance_message',
        'recaptcha_site_key',
        'recaptcha_secret_key',
    ];

    /**
     * Field script (berisi HTML/JS) yang harus divalidasi lebih ketat.
     */
    protected array $scriptFields = [
        'ad_header_script',
        'ad_sidebar_script',
        'ad_in_article_script',
    ];

    /**
     * Pola berbahaya yang TIDAK boleh ada dalam script field.
     * Ini mencegah redirect berbahaya dan code injection.
     */
    protected array $dangerousPatterns = [
        'window.location',
        'document.location',
        'location.href',
        'location.replace',
        'location.assign',
        'document.write',
        'eval(',
        'setTimeout(',
        'setInterval(',
        'Function(',
        'base64_decode',
        'atob(',
        'fromCharCode',
        '<meta http-equiv',
        'http-equiv="refresh"',
        'http-equiv=\'refresh\'',
        'XMLHttpRequest',
        'fetch(',
    ];

    public function index()
    {
        $settings = Configuration::pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validasi dasar
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'site_copyright' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|url|max:255',
            'social_twitter' => 'nullable|url|max:255',
            'social_youtube' => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_google' => 'nullable|url|max:255',
            'ad_header_url' => 'nullable|url|max:500',
            'ad_sidebar_url' => 'nullable|url|max:500',
            'ad_in_article_url' => 'nullable|url|max:500',
            'mail_port' => 'nullable|integer|between:1,65535',
            'mail_from_address' => 'nullable|email|max:255',
            'maintenance_mode' => 'nullable|in:0,1',
        ]);

        // Hanya proses key yang ada di whitelist
        $data = $request->only($this->allowedKeys);

        foreach ($data as $key => $value) {
            // Skip file inputs
            if ($request->hasFile($key)) {
                continue;
            }

            // Validasi ekstra untuk field script - cek pola berbahaya
            if (in_array($key, $this->scriptFields) && !empty($value)) {
                $lowerValue = strtolower($value);
                foreach ($this->dangerousPatterns as $pattern) {
                    if (str_contains($lowerValue, strtolower($pattern))) {
                        // Log percobaan injeksi
                        Log::warning('SECURITY: Dangerous pattern detected in settings', [
                            'key' => $key,
                            'pattern' => $pattern,
                            'user_id' => auth()->id(),
                            'ip' => request()->ip(),
                        ]);
                        return back()
                            ->withInput()
                            ->withErrors([
                                $key => "Script tidak diizinkan mengandung \"{$pattern}\". Hanya kode AdSense/GTM yang valid."
                            ]);
                    }
                }
            }

            Configuration::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Handle File Uploads
        $this->handleFileUpload($request, 'site_logo');
        $this->handleFileUpload($request, 'site_favicon');
        $this->handleFileUpload($request, 'ad_header_image');
        $this->handleFileUpload($request, 'ad_sidebar_image');
        $this->handleFileUpload($request, 'ad_in_article_image');

        Log::info('Settings updated by user', [
            'user_id' => auth()->id(),
            'ip' => request()->ip(),
        ]);

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
                $image->scale(width: 128);
            } else {
                $image->scale(width: 1200);
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
