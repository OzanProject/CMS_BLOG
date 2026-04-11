<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "--- METADATA AUDIT ---\n";
echo "ADS.TXT: " . (App\Models\Configuration::where('key', 'ads_txt_content')->value('value') ? "PRESENT" : "EMPTY") . "\n";
echo "SITE NAME: " . App\Models\Configuration::where('key', 'site_name')->value('value') . "\n";
echo "YOUTUBE: " . App\Models\Configuration::where('key', 'homepage_youtube_url')->value('value') . "\n";

echo "\n--- PAGES AUDIT ---\n";
foreach(App\Models\Page::all() as $p) {
    echo "- " . $p->title . " (" . $p->slug . ") - Content: " . (strlen($p->content) > 100 ? "Valid" : "Thin/Empty") . "\n";
}

echo "\n--- AD CONFIG AUDIT ---\n";
$ads = App\Models\Configuration::where('key', 'like', 'ad%')->get();
foreach($ads as $ad) {
    echo "  " . $ad->key . ": " . (empty($ad->value) ? "EMPTY" : "READY (" . strlen($ad->value) . " bytes)") . "\n";
}
