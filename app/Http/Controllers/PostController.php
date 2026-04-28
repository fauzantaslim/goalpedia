<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Settings\GeneralSettings;
use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    /**
     * Handle 3-segment URLs: /{parentSlug}/{categorySlug}/{postSlug}
     * Used when the category has a parent (e.g. /kompetisi/liga-inggris/post-slug)
     */
    public function show(string $parentSlug, string $categorySlug, string $postSlug, GeneralSettings $settings): View
    {
        $category = Category::with('parent')
            ->where('slug', $categorySlug)
            ->where('is_visible', true)
            ->firstOrFail();

        return $this->resolveAndShow($category, $postSlug, $settings);
    }

    /**
     * Handle 2-segment URLs: /{categorySlug}/{postSlug}
     * Used when the category has no parent (e.g. /pemain/post-slug)
     */
    public function showFlat(string $categorySlug, string $postSlug, GeneralSettings $settings): View
    {
        $category = Category::with('parent')
            ->where('slug', $categorySlug)
            ->where('is_visible', true)
            ->firstOrFail();

        // If category actually has a parent, redirect to the canonical 3-segment URL
        if ($category->parent) {
            return redirect()->route('blog.post.show', [
                $category->parent->slug,
                $category->slug,
                $postSlug,
            ], 301);
        }

        return $this->resolveAndShow($category, $postSlug, $settings);
    }

    /**
     * Core logic shared between show() and showFlat().
     */
    private function resolveAndShow(Category $category, string $postSlug, GeneralSettings $settings): View
    {
        $post = Post::query()
            ->with(['user', 'category.parent', 'tags', 'faqs'])
            ->whereBelongsTo($category)
            ->where('slug', $postSlug)
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        $post->increment('views_count');

        $relatedPosts = Post::query()
            ->with(['category.parent'])
            ->where('status', 'published')
            ->whereBelongsTo($post->category)
            ->whereKeyNot($post->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularPosts = Post::query()
            ->with(['category.parent'])
            ->where('status', 'published')
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $latestPosts = Post::query()
            ->with(['category.parent', 'user'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->whereKeyNot($post->id)
            ->latest('published_at')
            ->take(6)
            ->get();

        $description = $post->meta_description ?: ($post->excerpt ?: str($post->content)->stripTags()->limit(160)->toString());

        $this->configureSeo(
            $post->title,
            $description,
            $post->getFirstMediaUrl('post_covers', 'optimized'),
            'Article'
        );

        SEOTools::jsonLd()->addValue('headline', $post->title);
        SEOTools::jsonLd()->addValue('author', [
            '@type' => 'Person',
            'name' => $post->user?->name ?? config('app.name'),
        ]);
        SEOTools::jsonLd()->addValue('publisher', [
            '@type' => 'Organization',
            'name' => $settings->site_name ?: config('app.name'),
            'logo' => [
                '@type' => 'ImageObject',
                'url' => $settings->logo_large_url ?? url('favicon.ico'),
            ],
        ]);
        SEOTools::jsonLd()->addValue('datePublished', $post->published_at?->toIso8601String());
        SEOTools::jsonLd()->addValue('dateModified', $post->updated_at?->toIso8601String());

        if ($post->faqs->isNotEmpty()) {
            $faqs = [];
            foreach ($post->faqs as $faq) {
                $faqs[] = [
                    '@type' => 'Question',
                    'name' => $faq->question,
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq->answer,
                    ],
                ];
            }
            SEOTools::jsonLd()->addValue('mainEntity', $faqs);
            SEOTools::jsonLd()->setType('FAQPage');
        }

        return view('blog.show', [
            'settings' => $settings,
            'post' => $post->fresh(['user', 'category', 'tags']),
            'relatedPosts' => $relatedPosts,
            'popularPosts' => $popularPosts,
            'latestPosts' => $latestPosts,
        ]);
    }
}
