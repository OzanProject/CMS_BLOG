<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$pages = [
    [
        'title' => 'Privacy Policy',
        'slug' => 'privacy-policy',
        'content' => '<h2>Privacy Policy</h2><p>Your privacy is important to us. It is our policy to respect your privacy regarding any information we may collect from you across our website. We only ask for personal information when we truly need it to provide a service to you. We collect it by fair and lawful means, with your knowledge and consent.</p><p>We don’t share any personally identifying information publicly or with third-parties, except when required to by law. Our website may link to external sites that are not operated by us. Please be aware that we have no control over the content and practices of these sites, and cannot accept responsibility or liability for their respective privacy policies.</p>',
    ],
    [
        'title' => 'Disclaimer',
        'slug' => 'disclaimer',
        'content' => '<h2>Disclaimer</h2><p>All the information on this website is published in good faith and for general information purpose only. We do not make any warranties about the completeness, reliability and accuracy of this information. Any action you take upon the information you find on this website is strictly at your own risk.</p><p>From our website, you can visit other websites by following hyperlinks to such external sites. While we strive to provide only quality links to useful and ethical websites, we have no control over the content and nature of these sites.</p>',
    ],
    [
        'title' => 'About Us',
        'slug' => 'about-us',
        'content' => '<h2>About Us</h2><p>Welcome to our site! we are dedicated to providing the best news and information content in the industry. Our team of experienced writers and editors work tirelessly to bring you the most accurate and up-to-date stories from around the world.</p><p>Founded in 2024, we have come a long way from our beginnings. When we first started out, our passion for high-quality journalism drove us to start our own business.</p>',
    ],
];

foreach ($pages as $pageData) {
    App\Models\Page::updateOrCreate(['slug' => $pageData['slug']], $pageData);
}

// Ensure in-article ads are active by default for testing
App\Models\Configuration::updateOrCreate(['key' => 'ad_in_article_active'], ['value' => '1']);

echo "Boilerplate pages seeded successfully.\n";
