<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $site_name;

    public string $site_description;

    public ?string $logo_url;

    public ?string $logo_small_url;

    public ?string $logo_large_url;

    public ?string $facebook_url;

    public ?string $instagram_url;

    public ?string $x_url;

    public ?string $default_meta_title;

    public ?string $default_meta_description;

    public static function group(): string
    {
        return 'general';
    }
}