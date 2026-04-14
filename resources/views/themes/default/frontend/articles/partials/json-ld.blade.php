@php
    // Siapkan data image, jangan diisi jika kosong
    $images = [];
    if (!empty($article->featured_image)) {
        $images[] = asset('storage/' . $article->featured_image);
    }

    // Bangun struktur data
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'NewsArticle',
        'headline' => $article->title,
        'description' => $article->meta_description ?? Str::limit(strip_tags($article->content), 160),
        'datePublished' => $article->published_at ? $article->published_at->toIso8601String() : now()->toIso8601String(),
        'dateModified' => $article->updated_at->toIso8601String(),
        'author' => [
            [
                '@type' => 'Person',
                'name' => $article->user->name ?? 'Admin',
                'url' => route('author.show', $article->user->username ?? Str::slug($article->user->name ?? 'admin'))
            ]
        ],
        'publisher' => [
            '@type' => 'Organization',
            'name' => $settings['site_name'] ?? 'DeepBlog',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('nextpage-lite/assets/img/logo.png')
            ]
        ]
    ];

    // Masukkan image hanya jika ada
    if (!empty($images)) {
        $schemaData['image'] = $images;
    }
@endphp

<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

