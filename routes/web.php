<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Spatie\Tags\Tag;

// STATIC PAGES
Route::get('/about-us', [PageController::class, 'about'])->name('page.about');
Route::get('/contact', [PageController::class, 'contact'])->name('page.contact');
Route::post('/contact', [PageController::class, 'submitContact'])
    ->name('contact.submit')
    ->middleware('throttle:5,1'); // Limit 5 requests per minute per IP
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('page.privacy');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('page.disclaimer');
Route::get('/terms-and-conditions', [PageController::class, 'tos'])->name('page.tos');

// Sitemap.xml (Dynamic)
Route::get('/sitemap.xml', function () {
    $sitemap = Sitemap::create();

    // Static Pages
    $sitemap->add(Url::create('/')
        ->setPriority(1.0)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));

    $sitemap->add(Url::create(route('page.about'))
        ->setPriority(0.8)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

    $sitemap->add(Url::create(route('page.contact'))
        ->setPriority(0.8)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

    $sitemap->add(Url::create(route('page.privacy'))
        ->setPriority(0.5)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));

    $sitemap->add(Url::create(route('page.disclaimer'))
        ->setPriority(0.5)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));

    $sitemap->add(Url::create(route('page.tos'))
        ->setPriority(0.5)
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));

    // Categories
    if (Schema::hasTable('categories')) {
        Category::query()
            ->where('is_visible', true)
            ->with('parent')
            ->get()
            ->each(function (Category $category) use ($sitemap) {
                $sitemap->add(Url::create(route('blog.category', $category->slug))
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
            });
    }

    // Tags
    Tag::all()
        ->each(function (Tag $tag) use ($sitemap) {
            $sitemap->add(Url::create(route('blog.tag', $tag->slug))
                ->setPriority(0.6)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        });

    // Posts (Published)
    if (Schema::hasTable('posts')) {
        Post::query()
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->with('category.parent')
            ->get()
            ->each(function (Post $post) use ($sitemap) {
                $category = $post->category;
                $segments = $category->parent
                    ? [$category->parent->slug, $category->slug, $post->slug]
                    : [$category->slug, $post->slug];
                $sitemap->add(Url::create(route('blog.post.show', $segments))
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.9)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
            });
    }

    return $sitemap->toResponse(request());
});

Route::get('/', [BlogController::class, 'index'])->name('blog.home');
Route::get('/kategori/{slug}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{slug}', [BlogController::class, 'tag'])->name('blog.tag');
Route::get('/search', [BlogController::class, 'search'])->name('blog.search');
Route::get('/penulis/{username}', [BlogController::class, 'author'])->name('blog.author');

// Post routes: 3-segment (parent/child/post) must come before 2-segment (category/post)
Route::get('/{parentSlug}/{categorySlug}/{postSlug}', [PostController::class, 'show'])->name('blog.post.show');
Route::get('/{categorySlug}/{postSlug}', [PostController::class, 'showFlat'])->name('blog.post.show.flat');
