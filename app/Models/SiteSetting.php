<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SiteSetting extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $guarded = [];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('site_logo')
            ->singleFile();

        $this
            ->addMediaCollection('site_logo_small')
            ->singleFile();

        $this
            ->addMediaCollection('site_logo_large')
            ->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(400)
            ->height(300)
            ->format('webp')
            ->quality(80)
            ->sharpen(10)
            ->nonQueued();

        $this->addMediaConversion('optimized')
            ->width(1200)
            ->height(630)
            ->format('webp')
            ->quality(85)
            ->sharpen(10)
            ->nonQueued();
    }
}
