<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class ContentInjector
{
    /**
     * Inject Ads and 'Read Also' into article content.
     *
     * @param string $content
     * @param string|null $adScript
     * @param \App\Models\Article|null $relatedArticle
     * @return string
     */
    public static function inject($content, $adScript = null, $relatedArticle = null)
    {
        if (empty($content)) {
            return '';
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

        // 2. Inject Ad after Paragraph 5 (index 4) or Middle if shorter
        if ($adScript) {
            $adPosition = 4; // Default after 5th paragraph
            
            // If article is short (e.g. 4 paragraphs), put ad after 2nd (along with Read Also? No, maybe after 3rd)
            if ($totalParagraphs <= 5 && $totalParagraphs > 2) {
                $adPosition = 2;
            }

            if (isset($paragraphs[$adPosition])) {
                $adHtml = self::getAdHtml($adScript);
                $paragraphs[$adPosition] .= $adHtml;
            }
        }

        // Reassemble content
        return implode('</p>', $paragraphs);
    }

    private static function getReadAlsoHtml($article)
    {
        $url = route('article.show', $article->slug);
        $title = $article->title;
        
        return '
        <div class="read-also-box my-4 p-3 border-start border-4 border-primary bg-light">
            <h6 class="m-0 fw-bold text-uppercase text-secondary" style="font-size: 12px; letter-spacing: 1px;">' . __('frontend.read_also') . '</h6>
            <a href="' . $url . '" class="text-dark fw-bold text-decoration-none h6 mt-1 d-block">' . $title . '</a>
        </div>';
    }

    private static function getAdHtml($script)
    {
        return '
        <div class="in-article-ad my-4 text-center">
            <span class="d-block text-muted small mb-1" style="font-size: 10px;">ADVERTISEMENT</span>
            ' . $script . '
        </div>';
    }
}
