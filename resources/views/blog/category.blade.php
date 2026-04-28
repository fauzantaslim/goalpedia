@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="array_filter([
        ['label' => 'Kategori'],
        $category->parent ? ['label' => $category->parent->name, 'url' => route('blog.category', $category->parent->slug)] : null,
        ['label' => $category->name],
    ])" />

    {{-- 1. Category Header --}}
    <header class="relative mb-14 overflow-hidden border-b-8 border-[var(--color-text-primary)] pb-10 pt-12">
        {{-- Decorative stripes --}}
        <div class="pointer-events-none absolute right-0 top-0 flex h-full items-end gap-2 opacity-[0.04]" aria-hidden="true">
            <div class="h-full w-12 -skew-x-6 bg-[var(--color-accent-secondary)]"></div>
            <div class="h-3/4 w-8 -skew-x-6 bg-[var(--color-accent-primary)]"></div>
        </div>

        <div class="mb-4 flex items-center gap-4">
            <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
            <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[var(--color-accent-secondary)]">Kanal Berita</p>
        </div>
        <h1 class="text-5xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] md:text-7xl lg:text-[90px]">{{ $category->name }}</h1>

        @if($category->children->isNotEmpty())
            <div class="mt-6 flex flex-wrap gap-2">
                @foreach($category->children as $child)
                    <a href="{{ route('blog.category', $child->slug) }}" class="border-2 border-[var(--color-text-primary)] px-4 py-1.5 text-[11px] font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)] transition-colors hover:bg-[var(--color-text-primary)] hover:text-[var(--color-bg-primary)]">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        @endif
        @if($category->description)
            <p class="mt-6 max-w-3xl border-l-4 border-[var(--color-accent-secondary)] pl-4 text-sm font-medium leading-relaxed text-[var(--color-text-secondary)] md:text-base">{{ $category->description }}</p>
        @endif
    </header>

    @if($posts->isEmpty())
        <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg-secondary)] opacity-30 py-20 text-center">
            <p class="text-sm font-medium text-[var(--color-text-secondary)] opacity-50 italic">Belum ada artikel di kategori ini.</p>
            <a href="{{ route('blog.home') }}" class="mt-6 inline-block text-sm font-bold text-[var(--color-accent-primary)] hover:underline">Kembali ke Beranda</a>
        </div>
    @else
                {{-- 2. MAIN GRID --}}
                <div class="lg:grid lg:grid-cols-[1fr_320px] lg:gap-12 lg:items-start border-t-8 border-[var(--color-text-primary)] pt-10">
                    <div class="flex flex-col gap-12">
                        @php $allPosts = $posts->items();
        $featuredPost = $posts->currentPage() === 1 ? array_shift($allPosts) : null; @endphp

                        @if($featuredPost)
                            <article class="group relative flex flex-col pb-10 border-b-4 border-[var(--color-text-primary)]">
                                @if($cover = $featuredPost->getFirstMediaUrl('post_covers', 'optimized'))
                                    <a href="{{ $featuredPost->postUrl() }}" class="block mb-6 overflow-hidden border border-[var(--color-border)] shadow-sm">
                                        <img src="{{ $cover }}" alt="{{ $featuredPost->title }}" fetchpriority="high" width="1200" height="630" class="w-full h-auto aspect-video object-cover transition-transform duration-700 group-hover:scale-105 grayscale hover:grayscale-0">
                                    </a>
                                @endif
                                <div class="flex flex-col">
                                    <div class="mb-4 flex items-center gap-3">
                                        <span class="bg-[var(--color-text-primary)] text-[var(--color-bg-primary)] px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em]">Featured</span>
                                        <time class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">
                                            {{ optional($featuredPost->published_at)->translatedFormat('d F Y') }}
                                        </time>
                                    </div>
                                    <h2 class="mb-4 text-3xl md:text-5xl lg:text-6xl font-black leading-[1.1] tracking-tighter text-[var(--color-text-primary)] group-hover:text-[var(--color-accent-primary)] transition-colors">
                                        <a href="{{ $featuredPost->postUrl() }}" class="before:absolute before:inset-0">
                                            {{ $featuredPost->title }}
                                        </a>
                                    </h2>
                                    <p class="max-w-2xl text-sm md:text-base leading-relaxed text-[var(--color-text-secondary)] opacity-80">
                                        {{ $featuredPost->excerpt }}
                                    </p>
                                </div>
                            </article>
                        @endif

                        <div class="flex flex-col gap-8">
                            @foreach($allPosts as $post)
                                <article class="group flex flex-col md:flex-row gap-6 border-b border-[var(--color-border)] pb-8 last:border-b-0 last:pb-0">
                                    @if($thumb = $post->getFirstMediaUrl('post_covers', 'thumb'))
                                        <a href="{{ $post->postUrl() }}" 
                                           class="block w-full md:w-1/3 shrink-0 aspect-[4/3] overflow-hidden border border-[var(--color-border)] shadow-sm">
                                            <img src="{{ $thumb }}" alt="{{ $post->title }}" loading="lazy" decoding="async"
                                                 width="400" height="300"
                                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale hover:grayscale-0">
                                        </a>
                                    @else
                                        <div class="w-full md:w-1/3 shrink-0 aspect-[4/3] bg-[var(--color-bg-secondary)] opacity-10 flex items-center justify-center border border-[var(--color-border)] shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-8 w-8 text-[var(--color-text-secondary)] opacity-10" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="flex flex-col justify-center">
                                        <time class="mb-2 text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-70">
                                            {{ optional($post->published_at)->diffForHumans() }}
                                        </time>
                                        <h3 class="mb-3 text-2xl font-black leading-tight tracking-tight text-[var(--color-text-primary)] group-hover:text-[var(--color-accent-primary)] transition-colors">
                                            <a href="{{ $post->postUrl() }}" class="no-underline">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-[var(--color-text-secondary)] opacity-70">
                                            {{ $post->excerpt }}
                                        </p>
                                        <div class="mt-auto flex items-center gap-2 text-[11px] font-semibold text-[var(--color-text-secondary)] opacity-70">
                                            <span>{{ $post->user?->name ?? 'Redaksi' }}</span>
                                            <span>&middot;</span>
                                            <span>{{ number_format($post->views_count) }} Views</span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                        <div class="mt-8">
                            <x-pagination :paginator="$posts" />
                        </div>
                    </div>

                    <aside class="mt-16 lg:mt-0 sticky top-24">
                        <div class="h-full space-y-12">
                            @if($recentPosts->isNotEmpty())
                                <div>
                                    <h3 class="mb-6 flex items-center gap-3 text-xs font-black uppercase tracking-[0.25em] text-[var(--color-accent-secondary)] border-b-2 border-accent-secondary pb-2">
                                    <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                                        Terbaru
                                    </h3>
                                    <div class="space-y-6">
                                        @foreach($recentPosts->take(5) as $r)
                                            <a href="{{ $r->postUrl() }}" 
                                               class="group flex items-center gap-4 no-underline">
                                                <div class="relative h-[56px] w-[74px] shrink-0 overflow-hidden rounded-lg bg-[var(--color-border)] opacity-40">
                                                    @if($rCover = $r->getFirstMediaUrl('post_covers', 'thumb'))
                                                        <img src="{{ $rCover }}" alt="{{ $r->title }}" loading="lazy" decoding="async"
                                                             width="400" height="300"
                                                             class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-[13px] font-bold leading-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                                                        {{ $r->title }}
                                                    </p>
                                                    <time class="mt-1.5 block text-[9px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">
                                                        {{ optional($r->published_at)->translatedFormat('d M Y') }}
                                                    </time>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </aside>
                </div>
    @endif

@endsection
