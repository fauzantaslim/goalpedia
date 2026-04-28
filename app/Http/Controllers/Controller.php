<?php

namespace App\Http\Controllers;

use App\Settings\GeneralSettings;
use Artesaos\SEOTools\Facades\SEOTools;

abstract class Controller
{
    /**
     * Helper to configure global SEO dynamically.
     */
    protected function configureSeo(string $title, string $description, ?string $image = null, string $type = 'WebPage')
    {
        $settings = app(GeneralSettings::class);
        $siteName = $settings->site_name ?: config('app.name');

        $metaTitle = str_contains($title, $siteName) ? $title : "{$title} | {$siteName}";

        SEOTools::setTitle($metaTitle);
        SEOTools::setDescription($description);

        SEOTools::opengraph()->setTitle($metaTitle);
        SEOTools::opengraph()->setDescription($description);
        SEOTools::opengraph()->setType(strtolower($type) === 'article' ? 'article' : 'website');

        SEOTools::jsonLd()->setTitle($metaTitle);
        SEOTools::jsonLd()->setDescription($description);
        SEOTools::jsonLd()->setType($type);

        SEOTools::twitter()->setTitle($metaTitle);
        SEOTools::twitter()->setDescription($description);

        $cover = $image ?: $settings->logo_large_url;
        if (filled($cover)) {
            SEOTools::opengraph()->addImage($cover);
            SEOTools::jsonLd()->addImage($cover);
            SEOTools::twitter()->setImage($cover);
        }
    }
}
