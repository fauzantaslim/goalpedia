<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Tags\Tag;

class BlogController extends Controller
{
    public function index(GeneralSettings $settings): View
    {
        $featuredPost = $this->publishedPostsQuery()
            ->latest('published_at')
            ->first();

        $latestPosts = $this->publishedPostsQuery()
            ->when($featuredPost, fn($query) => $query->whereKeyNot($featuredPost->id))
            ->latest('published_at')
            ->take(6)
            ->get();

        $popularPosts = $this->publishedPostsQuery()
            ->orderByDesc('views_count')
            ->take(5)
            ->get();

        $categoriesWithPosts = Category::query()
            ->with('children')
            ->where('is_visible', true)
            ->whereNull('parent_id')
            ->get()
            ->map(function ($category) {
                $categoryIds = $category->children->pluck('id')->push($category->id);

                $postsQuery = Post::query()
                    ->whereIn('category_id', $categoryIds)
                    ->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());

                $category->posts_count = $postsQuery->count();

                $category->setRelation(
                    'posts',
                    (clone $postsQuery)
                        ->with(['user', 'category.parent'])
                        ->latest('published_at')
                        ->take(4)
                        ->get()
                );

                return $category;
            })
            ->filter(fn($cat) => $cat->posts_count > 0)
            ->sortByDesc('posts_count')
            ->values();

        $popularTagIds = \Illuminate\Support\Facades\DB::table('taggables')
            ->select('tag_id', \Illuminate\Support\Facades\DB::raw('COUNT(*) as count'))
            ->where('taggable_type', Post::class)
            ->groupBy('tag_id')
            ->orderByDesc('count')
            ->take(15)
            ->pluck('tag_id');

        $popularTags = Tag::whereIn('id', $popularTagIds)
            ->get()
            ->sortBy(fn($tag) => array_search($tag->id, $popularTagIds->toArray()))
            ->values();

        $this->configureSeo(
            $settings->default_meta_title ?: 'Home',
            $settings->default_meta_description ?: $settings->site_description,
            null,
            'WebSite'
        );

        return view('blog.index', [
            'settings' => $settings,
            'featuredPost' => $featuredPost,
            'latestPosts' => $latestPosts,
            'popularPosts' => $popularPosts,
            'categoriesWithPosts' => $categoriesWithPosts,
            'popularTags' => $popularTags,
        ]);
    }

    public function category(string $slug, GeneralSettings $settings): View
    {
        $category = Category::query()
            ->with([
                'parent',
                'children' => function ($q) {
                    $q->where('is_visible', true);
                }
            ])
            ->where('slug', $slug)
            ->where('is_visible', true)
            ->firstOrFail();

        $perPage = (int) request()->get('per_page', 5);
        $perPage = in_array($perPage, [5, 10, 15, 20]) ? $perPage : 5;

        $categoryIds = $category->children->pluck('id')->push($category->id);

        $posts = $this->publishedPostsQuery()
            ->whereIn('category_id', $categoryIds)
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();

        $this->configureSeo(
            "Kategori: {$category->name}",
            $category->description ?: $settings->site_description,
            null,
            'CollectionPage'
        );

        return view('blog.category', [
            'settings' => $settings,
            'category' => $category,
            'posts' => $posts,
            'recentPosts' => $this->publishedPostsQuery()->whereIn('category_id', $categoryIds)->latest('published_at')->take(5)->get(),
            'popularPosts' => $this->publishedPostsQuery()->whereIn('category_id', $categoryIds)->orderByDesc('views_count')->take(5)->get(),
        ]);
    }

    public function tag(string $slug, GeneralSettings $settings): View
    {
        $locale = app()->getLocale();

        $tag = Tag::query()
            ->where("slug->{$locale}", $slug)
            ->orWhere('slug->en', $slug)
            ->firstOrFail();

        $perPage = (int) request()->get('per_page', 9);
        $perPage = in_array($perPage, [6, 9, 12, 18]) ? $perPage : 9;

        $posts = $this->publishedPostsQuery()
            ->withAnyTags([$tag])
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();

        $tagName = $tag->name;

        $this->configureSeo(
            "Tag: {$tagName}",
            "Artikel dengan tag {$tagName} di {$settings->site_name}.",
            null,
            'CollectionPage'
        );

        return view('blog.tag', [
            'settings' => $settings,
            'tag' => $tag,
            'posts' => $posts,
        ]);
    }

    public function search(GeneralSettings $settings): View
    {
        $query = request()->get('q');

        $posts = $this->publishedPostsQuery()
            ->when($query, function ($q) use ($query) {
                $q->whereFullText(['title', 'content', 'excerpt'], $query);
            })
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $this->configureSeo(
            "Cari: {$query}",
            "Hasil pencarian untuk '{$query}' di {$settings->site_name}.",
            null,
            'SearchResultsPage'
        );

        return view('blog.search', [
            'settings' => $settings,
            'posts' => $posts,
            'query' => $query,
        ]);
    }

    public function author(string $username, GeneralSettings $settings): View
    {
        $author = User::query()
            ->where('name', $username)
            ->firstOrFail();

        $perPage = (int) request()->get('per_page', 9);
        $perPage = in_array($perPage, [6, 9, 12, 18]) ? $perPage : 9;

        $posts = $this->publishedPostsQuery()
            ->where('user_id', $author->id)
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();

        $popularPost = $this->publishedPostsQuery()
            ->where('user_id', $author->id)
            ->orderByDesc('views_count')
            ->first();

        $totalViews = Post::query()
            ->where('user_id', $author->id)
            ->where('status', 'published')
            ->sum('views_count');

        $this->configureSeo(
            "Penulis: {$author->name}",
            "Baca semua artikel sepak bola dari {$author->name} di {$settings->site_name}.",
            null,
            'ProfilePage'
        );

        return view('blog.author', [
            'settings' => $settings,
            'author' => $author,
            'posts' => $posts,
            'popularPost' => $popularPost,
            'totalViews' => $totalViews,
        ]);
    }

    private function publishedPostsQuery(): Builder
    {
        return Post::query()
            ->with(['user', 'category.parent', 'tags'])
            ->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
