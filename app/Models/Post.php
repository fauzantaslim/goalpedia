<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\Tags\HasTags;

class Post extends Model implements HasMedia
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use HasSlug;
    use HasTags;
    use InteractsWithMedia;
    use LogsActivity;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'meta_description',
        'content',
        'status',
        'published_at',
        'views_count',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'views_count' => 'integer',
    ];

    protected $attributes = [
        'status' => 'draft',
        'views_count' => 0,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Returns the correct full URL for the post.
     * Uses 3-segment route if parent category exists, otherwise 2-segment route.
     *
     * @return string
     */
    public function postUrl(): string
    {
        $category = $this->category;

        if (! $category) {
            return route('blog.post.show.flat', ['umum', $this->slug]);
        }

        return $category->parent
            ? route('blog.post.show', [$category->parent->slug, $category->slug, $this->slug])
            : route('blog.post.show.flat', [$category->slug, $this->slug]);
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(PostFaq::class)->orderBy('sort_order');
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['title', 'slug', 'status'])
            ->logOnlyDirty();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('post_covers')
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
