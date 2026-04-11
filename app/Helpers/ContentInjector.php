<?php

namespace App\Helpers;

class ContentInjector
{
    /**
     * Inject Ads and 'Read Also' into article content.
     *
     * @param string $content
     * @param \Illuminate\Support\Collection|array|null $settings
     * @param \App\Models\Article|null $relatedArticle
     * @return string
     */
    public static function inject($content, $settings = null, $relatedArticle = null)
    {
        if (empty($content)) {
            return '';
        }

        // Normalize settings
        if (is_null($settings)) {
            $settings = \App\Models\Configuration::pluck('value', 'key');
        }

        $isActive       = ($settings['ad_in_article_active'] ?? '0') === '1';
        $frequency      = (int) ($settings['ad_in_article_frequency'] ?? 3);
        $maxAds         = (int) ($settings['ad_in_article_max'] ?? 5);
        $adScript       = $settings['ad_in_article_script'] ?? null;

        // Explode content by closing paragraph tag
        $paragraphs = explode('</p>', $content);
        $totalParagraphs = count($paragraphs);

        // 1. Inject "Read Also" after Paragraph 2 (index 1)
        if ($totalParagraphs > 2 && $relatedArticle) {
            $readAlsoHtml = self::getReadAlsoHtml($relatedArticle);
            if (isset($paragraphs[1])) {
                $paragraphs[1] .= $readAlsoHtml;
            }
        }

        // 2. Inject Ads dynamically
        if ($isActive && !empty($adScript) && $frequency > 0) {
            $adCount = 0;

            for ($i = $frequency - 1; $i < $totalParagraphs - 1; $i += $frequency) {
                if ($adCount >= $maxAds) break;

                // Don't inject right after "Read Also" block
                if ($i === 1) continue;

                if (isset($paragraphs[$i])) {
                    $paragraphs[$i] .= self::getAdHtml($adScript);
                    $adCount++;
                }
            }
        }

        return implode('</p>', $paragraphs);
    }

    private static function getReadAlsoHtml($article)
    {
        $url   = route('article.show', $article->slug);
        $title = e($article->title);

        return '
        <div class="read-also-box my-6 p-4 border-l-4 border-amber-500 bg-slate-900/50 rounded-r-xl">
            <span class="block text-[10px] font-black uppercase tracking-widest text-amber-500/70 mb-2">Baca Juga</span>
            <a href="' . $url . '" class="text-white font-bold text-sm hover:text-amber-400 transition-colors leading-snug">' . $title . '</a>
        </div>';
    }

    private static function getAdHtml($script)
    {
        return '
        <div class="in-article-ad my-8 text-center">
            <span class="block text-[9px] font-black uppercase tracking-[0.3em] text-slate-600 mb-3">Advertisement</span>
            <div class="overflow-hidden rounded-xl">
                ' . $script . '
            </div>
        </div>';
    }
}
