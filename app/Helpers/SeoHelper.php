<?php

namespace App\Helpers;

use App\Models\SeoSetting;
use App\Models\SiteSetting;

class SeoHelper
{
    private SeoSetting $seo;
    private string     $siteUrl;

    public function __construct(string $page = 'home')
    {
        $this->seo     = SeoSetting::forPage($page) ?? new SeoSetting();
        $this->siteUrl = config('app.url');
    }

    public static function for(string $page = 'home'): self
    {
        return new self($page);
    }

    public function title(): string
    {
        return $this->seo->meta_title
            ?? SiteSetting::get('site_name', 'Enrique Delgado — El Psicólogo del Cambio');
    }

    public function description(): string
    {
        return $this->seo->meta_description ?? '';
    }

    public function canonical(): string
    {
        return $this->seo->canonical_url ?? url()->current();
    }

    public function robots(): string
    {
        $parts = [];
        $parts[] = $this->seo->noindex  ? 'noindex'  : 'index';
        $parts[] = $this->seo->nofollow ? 'nofollow' : 'follow';
        return implode(', ', $parts);
    }

    public function ogImage(): string
    {
        if ($this->seo->og_image) {
            return asset('storage/' . $this->seo->og_image);
        }
        return asset('images/og-default.jpg');
    }

    public function ogTitle(): string
    {
        return $this->seo->og_title ?? $this->title();
    }

    public function ogDescription(): string
    {
        return $this->seo->og_description ?? $this->description();
    }

    public function renderTags(): string
    {
        $siteName = e(SiteSetting::get('site_name', 'Enrique Delgado'));

        return implode("\n    ", [
            '<title>' . e($this->title()) . '</title>',
            '<meta name="description" content="' . e($this->description()) . '">',
            '<link rel="canonical" href="' . e($this->canonical()) . '">',
            '<meta name="robots" content="' . $this->robots() . '">',
            '<!-- Open Graph -->',
            '<meta property="og:type" content="website">',
            '<meta property="og:site_name" content="' . e($siteName) . '">',
            '<meta property="og:title" content="' . e($this->ogTitle()) . '">',
            '<meta property="og:description" content="' . e($this->ogDescription()) . '">',
            '<meta property="og:image" content="' . e($this->ogImage()) . '">',
            '<meta property="og:url" content="' . e($this->canonical()) . '">',
            '<!-- Twitter Card -->',
            '<meta name="twitter:card" content="summary_large_image">',
            '<meta name="twitter:title" content="' . e($this->ogTitle()) . '">',
            '<meta name="twitter:description" content="' . e($this->ogDescription()) . '">',
            '<meta name="twitter:image" content="' . e($this->ogImage()) . '">',
        ]);
    }
}
