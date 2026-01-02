<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ addslashes($article->title) }}",
  "image": [
    "{{ asset('storage/' . $article->featured_image) }}"
   ],
  "datePublished": "{{ $article->published_at ? $article->published_at->toIso8601String() : now()->toIso8601String() }}",
  "dateModified": "{{ $article->updated_at->toIso8601String() }}",
  "author": [{
      "@type": "Person",
      "name": "{{ $article->user->name ?? 'Admin' }}",
      "url": "{{ route('author.show', $article->user->username ?? \Illuminate\Support\Str::slug($article->user->name ?? 'admin')) }}"
    }],
  "publisher": {
    "@type": "Organization",
    "name": "{{ $settings['site_name'] ?? 'DeepBlog' }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ isset($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : asset('nextpage-lite/assets/img/logo.png') }}"
    }
  }
}
</script>
