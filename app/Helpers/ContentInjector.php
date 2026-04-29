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

        // Explode content by closing paragraph tag (case-insensitive)
        $paragraphs = preg_split('/<\/p>/i', $content);
        $totalParagraphs = count($paragraphs);

        // 1. Inject "Read Also" after Paragraph 2 (index 1)
        if ($totalParagraphs > 2 && $relatedArticle) {
            $readAlsoHtml = self::getReadAlsoHtml($relatedArticle);
            if (isset($paragraphs[1])) {
                $paragraphs[1] .= $readAlsoHtml;
            }
        }

        /*
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
        */

        return implode('</p>', $paragraphs);
    }

    private static function getReadAlsoHtml($article)
    {
        $url   = route('article.show', $article->slug);
        $title = e($article->title);
        $label = __('frontend.read_also') ?: 'READ ALSO';

        return '
        <div class="read-also-box" style="margin: 32px 0; padding: 20px; border-left: 4px solid #2170e4; background: #f8fafc; border-radius: 0 12px 12px 0; border: 1px solid #e2e8f0; border-left-width: 4px;">
            <span style="display: block; font-family: \'Manrope\', sans-serif; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em; color: #2170e4; margin-bottom: 8px;">' . $label . '</span>
            <a href="' . $url . '" style="font-family: \'Manrope\', sans-serif; font-weight: 700; font-size: 17px; text-decoration: none; color: #1e293b; display: block; line-height: 1.4;">' . $title . '</a>
        </div>';
    }

    private static function getAdHtml($script)
    {
        return '
        <div class="in-article-ad" style="margin: 40px 0; text-align: center;">
            <span style="display: block; font-family: \'Manrope\', sans-serif; font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.2em; color: #94a3b8; margin-bottom: 12px;">Advertisement</span>
            <div style="overflow: hidden; border-radius: 12px;">
                ' . $script . '
            </div>
        </div>';
    }
}
