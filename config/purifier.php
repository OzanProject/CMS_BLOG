<?php

return [
    'encoding'      => 'UTF-8',
    'finalize'      => true,
    'cachePath'     => storage_path('app/purifier'),
    'cacheFileMode' => 0755,

    'settings'      => [
        'default' => [
            'HTML.Doctype'             => 'HTML 4.01 Transitional',
            'HTML.Allowed'             => 'h1,h2,h3,h4,h5,h6[style|class|id],p[style|class],br,hr,b,strong,i,em,u,s,strike,sub,sup,ul[style],ol[style],li[style],blockquote[style|cite],a[href|title|target|rel],img[src|alt|title|width|height|style|class],table[style|class|border|cellpadding|cellspacing|width],thead,tbody,tfoot,tr,th[style|colspan|rowspan],td[style|colspan|rowspan],div[style|class],span[style|class],pre[class],code[class]',
            'CSS.AllowedProperties'    => 'font,font-size,font-weight,font-style,font-family,text-decoration,text-align,color,background-color,padding,padding-top,padding-right,padding-bottom,padding-left,margin,margin-top,margin-right,margin-bottom,margin-left,border,border-color,border-style,border-width,width,height,float,clear,line-height,letter-spacing,list-style-type,vertical-align',
            'CSS.Trusted'              => true,
            'CSS.AllowTricky'          => true,
            'AutoFormat.AutoParagraph' => false,
            'AutoFormat.RemoveEmpty'   => false,
            'HTML.SafeIframe'          => true,
            'URI.SafeIframeRegexp'     => '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%',
        ],
        'excerpt' => [
            'HTML.Allowed'             => 'p,br,b,strong,i,em,a[href]',
            'AutoFormat.RemoveEmpty'   => true,
        ],
        'comment' => [
            'HTML.Allowed'             => 'p,br,b,strong,i,em',
            'AutoFormat.RemoveEmpty'   => true,
        ],
    ],
];
