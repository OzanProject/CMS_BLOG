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

        // If $settings is a string, it means the caller passed the script directly
        if (is_string($settings)) {
            $adScript = $settings;
            // Fetch missing flags if needed, or assume defaults
            $isActive  = !empty($adScript);
            $frequency = 3;
            $maxAds    = 5;
        } else {
            $isActive       = ($settings['ad_in_article_active'] ?? '0') === '1';
            $frequency      = (int) ($settings['ad_in_article_frequency'] ?? 3);
            $maxAds         = (int) ($settings['ad_in_article_max'] ?? 5);
            $adScript       = $settings['ad_in_article_script'] ?? null;
        }

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
        $label = __('frontend.read_also') ?: 'Read Also';

        return '
        <div class="read-also-box" style="margin: 25px 0; padding: 15px 20px; border-left: 4px solid #f59e0b; background: rgba(128,128,128,0.08); border-radius: 0 10px 10px 0;">
            <span style="display: block; font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: 1.5px; color: #f59e0b; margin-bottom: 6px;">' . $label . '</span>
            <a href="' . $url . '" style="font-weight: 700; font-size: 16px; text-decoration: none; display: block; line-height: 1.4;">' . $title . '</a>
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
