@extends('layouts.app')

@section('content')

    {{-- 1. HERO: Magazine Grid Layout --}}
    @php
        $heroSide = $latestPosts->take(4)->values();
        $heroLeft = $heroSide->take(2)->values();
        $heroRight = $heroSide->slice(2, 2)->values();
        $remainingPosts = $latestPosts->skip(4)->values();
    @endphp

    @if($featuredPost || $heroSide->isNotEmpty())
    <section class="mb-14 border-b-8 border-[var(--color-text-primary)] pb-10">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-[1fr_2.5fr_1fr]">

            {{-- LEFT COLUMN: Text Heavy News --}}
            <div class="flex flex-col gap-6 border-r-0 lg:border-r-2 border-[var(--color-text-primary)] lg:pr-8">
                <div class="border-b-4 border-[var(--color-text-primary)] pb-2 mb-2 flex items-center gap-2">
                    <div class="h-2 w-2 rotate-45 bg-[var(--color-accent-secondary)] shrink-0"></div>
                    <h3 class="text-sm font-black uppercase tracking-widest text-[var(--color-accent-secondary)]">HOT NEWS</h3>
                </div>
                @foreach($heroLeft as $post)
                    <article class="group relative flex flex-col gap-3 pb-6 border-b border-[var(--color-border)] last:border-b-0 last:pb-0">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-[var(--color-accent-primary)] hover:underline">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h4 class="text-lg font-bold leading-snug tracking-tight text-[var(--color-text-primary)] group-hover:text-[var(--color-accent-primary)] transition-colors">
                            <a href="{{ $post->postUrl() }}" class="after:absolute after:inset-0">
                                {{ $post->title }}
                            </a>
                        </h4>
                        <time class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">
                            {{ optional($post->published_at)->diffForHumans() }}
                        </time>
                    </article>
                @endforeach
            </div>

            {{-- CENTER: Massive Featured Post --}}
            <div class="flex flex-col">
                @if($featuredPost)
                    @php $featuredCover = $featuredPost->getFirstMediaUrl('post_covers', 'optimized'); @endphp
                    <article class="group relative flex flex-col">
                        @if($featuredCover)
                            <a href="{{ $featuredPost->postUrl() }}" class="block mb-6 overflow-hidden border border-[var(--color-border)] shadow-sm">
                                <img src="{{ $featuredCover }}" alt="{{ $featuredPost->title }}" fetchpriority="high" width="1200" height="630" class="w-full h-auto aspect-video object-cover transition-transform duration-700 group-hover:scale-105 grayscale hover:grayscale-0">
                            </a>
                        @endif
                        <div class="flex flex-col items-center text-center px-4">
                            <div class="mb-4 flex items-center justify-center gap-3">
                                <span class="bg-[var(--color-text-primary)] text-[var(--color-bg-primary)] px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em]">Featured</span>
                                @if($featuredPost->category)
                                    <a href="{{ route('blog.category', $featuredPost->category->slug) }}" class="text-[11px] font-black uppercase tracking-widest text-[var(--color-accent-secondary)] hover:underline">
                                        {{ $featuredPost->category->name }}
                                    </a>
                                @endif
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
            </div>

            {{-- RIGHT COLUMN: Thumbnail + Text --}}
            <div class="flex flex-col gap-6 border-l-0 lg:border-l-2 border-[var(--color-text-primary)] lg:pl-8 mt-8 lg:mt-0 border-t-2 lg:border-t-0 pt-8 lg:pt-0">
                <div class="border-b-4 border-[var(--color-text-primary)] pb-2 mb-2 flex items-center gap-2">
                    <div class="h-2 w-2 rotate-45 bg-[var(--color-accent-secondary)] shrink-0"></div>
                    <h3 class="text-sm font-black uppercase tracking-widest text-[var(--color-accent-secondary)]">Live Update</h3>
                </div>
                @foreach($heroRight as $post)
                    @php $thumb = $post->getFirstMediaUrl('post_covers', 'thumb'); @endphp
                    <article class="group relative flex flex-col gap-3 pb-6 border-b border-[var(--color-border)] last:border-b-0 last:pb-0">
                        @if($thumb)
                            <a href="{{ $post->postUrl() }}" class="block aspect-video overflow-hidden border border-[var(--color-border)] shadow-sm">
                                <img src="{{ $thumb }}" alt="{{ $post->title }}" width="400" height="300" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            </a>
                        @endif
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-[var(--color-accent-primary)] hover:underline mt-2">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <h4 class="text-base font-bold leading-snug tracking-tight text-[var(--color-text-primary)] group-hover:text-[var(--color-accent-primary)] transition-colors">
                            <a href="{{ $post->postUrl() }}" class="after:absolute after:inset-0">
                                {{ $post->title }}
                            </a>
                        </h4>
                    </article>
                @endforeach
            </div>

        </div>
    </section>
    @endif

    {{-- 2. MAIN GRID: Latest & Popular & Categories --}}
    <div class="mx-auto max-w-7xl">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-[1fr_320px] xl:grid-cols-[1fr_380px]">

            {{-- LEFT COLUMN: LATEST & CATEGORIES --}}
            <div class="flex flex-col gap-16">

                {{-- LATEST POSTS --}}
                <section>
                    <div class="mb-8 border-b-4 border-[var(--color-text-primary)] pb-2">
                        <h2 class="text-3xl font-black uppercase tracking-widest text-[var(--color-text-primary)]">Berita Terkini</h2>
                    </div>

                    <div class="flex flex-col gap-8">
                        @forelse($remainingPosts as $post)
                            <article class="group flex flex-col md:flex-row gap-6 border-b border-[var(--color-border)] pb-8 last:border-b-0 last:pb-0">
                                @if($thumb = $post->getFirstMediaUrl('post_covers', 'thumb'))
                                    <a href="{{ $post->postUrl() }}"
                                       class="block w-full md:w-1/3 shrink-0 aspect-[4/3] overflow-hidden border border-[var(--color-border)] shadow-sm">
                                        <img src="{{ $thumb }}" alt="{{ $post->title }}" loading="lazy" decoding="async" width="400" height="300" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale hover:grayscale-0">
                                    </a>
                                @endif

                                <div class="flex flex-col justify-center">
                                    <div class="mb-2 flex items-center gap-3">
                                        @if($post->category)
                                            <a href="{{ route('blog.category', $post->category->slug) }}"
                                               class="bg-[var(--color-accent-primary)] text-[var(--color-bg-primary)] px-2 py-0.5 text-[10px] font-black uppercase tracking-widest hover:bg-[var(--color-accent-secondary)] transition-colors">
                                                {{ $post->category->name }}
                                            </a>
                                        @endif
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-70">
                                            {{ optional($post->published_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                    <h3 class="mb-3 text-2xl font-black leading-tight tracking-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                                        <a href="{{ $post->postUrl() }}" class="no-underline">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-[var(--color-text-secondary)]">
                                        {{ $post->excerpt }}
                                    </p>
                                    <div class="mt-auto flex items-center gap-2 text-[10px] font-black uppercase tracking-widest opacity-60">
                                        <span>OLEH {{ $post->user?->name ?? 'Redaksi' }}</span>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="py-10 text-center text-sm font-bold uppercase tracking-widest opacity-50">Belum ada artikel terbaru.</p>
                        @endforelse
                    </div>
                </section>

                {{-- CATEGORIES BLOCK --}}
                <div class="mt-8 border-t-8 border-[var(--color-text-primary)] pt-12 flex flex-col gap-16">
                    @foreach($categoriesWithPosts as $cat)
                    <section class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="md:col-span-1 border-r-0 md:border-r-2 border-[var(--color-border)] pr-0 md:pr-8">
                            <h2 class="text-4xl font-black uppercase tracking-tighter text-[var(--color-text-primary)] mb-4">{{ $cat->name }}</h2>
                            <a href="{{ route('blog.category', $cat->slug) }}" class="inline-flex items-center gap-2 text-[11px] font-black uppercase tracking-widest text-[var(--color-accent-secondary)] hover:text-[var(--color-accent-primary)] transition-colors">
                                Lihat Semua Kanal
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>

                        <div class="md:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-8">
                            @foreach($cat->posts as $post)
                                <article class="group flex flex-col gap-3">
                                    @if($thumb = $post->getFirstMediaUrl('post_covers', 'thumb'))
                                        <a href="{{ $post->postUrl() }}" class="block w-full aspect-video overflow-hidden border border-[var(--color-border)] shadow-sm">
                                            <img src="{{ $thumb }}" alt="{{ $post->title }}" loading="lazy" decoding="async" width="400" height="300" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        </a>
                                    @endif
                                    <div>
                                        <time class="mb-1 block text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-70">
                                            {{ optional($post->published_at)->diffForHumans() }}
                                        </time>
                                        <h3 class="text-base font-bold leading-tight tracking-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                                            <a href="{{ $post->postUrl() }}" class="no-underline">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                    @endforeach
                </div>

            </div>

            {{-- RIGHT COLUMN: POPULAR --}}
            <aside class="flex flex-col gap-12">
                {{-- TOP TAGS --}}
                @if(isset($popularTags) && $popularTags->isNotEmpty())
                    <div>
                        <div class="mb-6 border-t-[6px] border-[var(--color-text-primary)] pt-4">
                            <h2 class="text-2xl font-black uppercase tracking-tighter md:text-3xl">Hot Tags</h2>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($popularTags as $tag)
                                <a href="{{ route('blog.tag', $tag->slug) }}" class="inline-flex items-center gap-1.5 border-2 border-[var(--color-border)] px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-[var(--color-text-primary)] transition-colors hover:border-[var(--color-accent-secondary)] hover:bg-[var(--color-accent-secondary)] hover:text-white">
                                    <span class="text-[var(--color-accent-primary)] opacity-50">#</span>{{ $tag->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- POPULAR POSTS --}}
                <div class="sticky top-24">
                    <div class="mb-8 border-t-[6px] border-[var(--color-text-primary)] pt-4">
                        <h2 class="text-2xl font-black uppercase tracking-tighter md:text-3xl">Terpopuler</h2>
                    </div>

                    <div class="flex flex-col">
                        @foreach($popularPosts as $index => $post)
                            <article class="group relative flex items-start gap-4 border-b border-[var(--color-border)] py-6 pt-5 hover:bg-[var(--color-text-primary)]/5">
                                <div class="font-serif text-5xl font-black leading-none text-[var(--color-text-primary)] opacity-10 transition-opacity group-hover:opacity-30">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex flex-col pt-1">
                                    @if($post->category)
                                        <a href="{{ route('blog.category', $post->category->slug) }}"
                                           class="mb-2 text-[9px] font-black uppercase tracking-widest text-[var(--color-accent-primary)] no-underline hover:underline">
                                            {{ $post->category->name }}
                                        </a>
                                    @endif
                                    <h3 class="text-base font-bold leading-tight tracking-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                                        <a href="{{ $post->postUrl() }}" class="after:absolute after:inset-0">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    <div class="mt-3 flex items-center gap-2 text-[9px] font-black uppercase tracking-widest opacity-60">
                                        <span>{{ number_format($post->views_count) }} TAYANGAN</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </aside>

        </div>
    </div>

@endsection
