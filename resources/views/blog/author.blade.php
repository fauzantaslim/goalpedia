@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Penulis'],
        ['label' => $author->name],
    ]" />

    {{-- ═══════════════════════════════════════════════════════════════════
         AUTHOR MASTHEAD — Sport Magazine Style
    ══════════════════════════════════════════════════════════════════════ --}}
    <header class="relative mb-0 overflow-hidden border-b-8 border-[var(--color-text-primary)]">

        {{-- Diagonal accent stripes (background) --}}
        <div class="pointer-events-none absolute right-0 top-0 flex h-full items-end gap-3 opacity-[0.05]" aria-hidden="true">
            <div class="h-full w-20 -skew-x-6 bg-[var(--color-accent-secondary)]"></div>
            <div class="h-4/5 w-12 -skew-x-6 bg-[var(--color-accent-primary)]"></div>
            <div class="h-3/5 w-8 -skew-x-6 bg-[var(--color-accent-secondary)]"></div>
        </div>

        <div class="relative z-10 grid grid-cols-1 items-end gap-0 lg:grid-cols-[1fr_auto]">

            {{-- Left: Author Identity --}}
            <div class="px-2 pb-10 pt-12 md:pb-14">
                <div class="mb-6 flex items-center gap-4">
                    <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[var(--color-accent-secondary)]">Profil Penulis</span>
                </div>

                <div class="flex flex-col gap-6 md:flex-row md:items-end">
                    {{-- Avatar --}}
                    <div class="shrink-0">
                        @php $avatarUrl = $author->getFirstMediaUrl('avatars'); @endphp
                        @if($avatarUrl)
                            <img src="{{ $avatarUrl }}"
                                 alt="{{ $author->name }}"
                                 class="h-28 w-28 border-4 border-[var(--color-text-primary)] object-cover md:h-36 md:w-36"
                                 width="144" height="144">
                        @else
                            <div class="flex h-28 w-28 items-center justify-center border-4 border-[var(--color-text-primary)] bg-[var(--color-text-primary)] md:h-36 md:w-36">
                                <span class="text-5xl font-black text-[var(--color-bg-primary)] md:text-6xl">
                                    {{ Str::upper(Str::substr($author->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Name + Bio --}}
                    <div>
                        <h1 class="text-5xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] md:text-7xl xl:text-[90px]">
                            {{ $author->name }}
                        </h1>
                        @if($author->bio)
                            <p class="mt-4 max-w-xl border-l-4 border-[var(--color-accent-secondary)] pl-4 text-sm font-medium leading-relaxed tracking-wide text-[var(--color-text-secondary)] md:text-base">
                                {{ $author->bio }}
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right: Stats Panel --}}
            <div class="grid grid-cols-3 border-t-4 border-[var(--color-text-primary)] lg:grid-cols-1 lg:border-l-8 lg:border-t-0">
                @foreach([
                    ['label' => 'Total Artikel', 'value' => $posts->total()],
                    ['label' => 'Total Pembaca', 'value' => number_format($totalViews)],
                    ['label' => 'Bergabung', 'value' => $author->created_at->format('Y')],
                ] as $stat)
                    <div class="group flex flex-col items-center justify-center border-r border-[var(--color-border)] px-8 py-6 text-center transition-colors last:border-r-0 hover:bg-[var(--color-text-primary)] lg:items-start lg:border-b lg:border-r-0 lg:text-left last:lg:border-b-0">
                        <p class="text-3xl font-black tracking-tighter text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-bg-primary)] lg:text-4xl">
                            {{ $stat['value'] }}
                        </p>
                        <p class="mt-0.5 text-[10px] font-black uppercase tracking-[0.25em] text-[var(--color-text-secondary)] transition-colors group-hover:text-[var(--color-bg-primary)]/60">
                            {{ $stat['label'] }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </header>

    {{-- ═══════════════════════════════════════════════════════════════════
         POPULAR PINNED ARTICLE (if exists)
    ══════════════════════════════════════════════════════════════════════ --}}
    @if($popularPost)
        @php $popularCover = $popularPost->getFirstMediaUrl('post_covers', 'optimized'); @endphp
        <section class="border-b-4 border-[var(--color-text-primary)]">
            <div class="mb-0 flex items-center gap-3 border-b border-[var(--color-border)] px-2 py-3">
                <div class="h-2 w-2 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                <span class="text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-accent-secondary)]">Artikel Terpopuler</span>
            </div>
            <article class="group relative grid grid-cols-1 gap-0 md:grid-cols-[1fr_1fr] lg:grid-cols-[1.2fr_1fr]">
                @if($popularCover)
                    <a href="{{ $popularPost->postUrl() }}"
                       class="block aspect-[16/9] overflow-hidden md:aspect-auto">
                        <img src="{{ $popularCover }}"
                             alt="{{ $popularPost->title }}"
                             fetchpriority="high"
                             width="1200" height="630"
                             class="h-full w-full object-cover grayscale transition-all duration-700 group-hover:scale-105 group-hover:grayscale-0">
                    </a>
                @endif
                <div class="flex flex-col justify-end border-l-0 border-t-4 border-[var(--color-text-primary)] p-8 md:border-l-4 md:border-t-0 lg:p-12">
                    <div class="mb-4 flex items-center gap-3">
                        <span class="bg-[var(--color-accent-secondary)] px-3 py-1 text-[10px] font-black uppercase tracking-[0.25em] text-white">
                            🏆 Most Read
                        </span>
                        @if($popularPost->category)
                            <a href="{{ route('blog.category', $popularPost->category->slug) }}"
                               class="text-[10px] font-black uppercase tracking-widest text-[var(--color-accent-primary)] hover:underline">
                                {{ $popularPost->category->name }}
                            </a>
                        @endif
                    </div>
                    <h2 class="mb-4 text-3xl font-black uppercase leading-tight tracking-tighter text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)] md:text-4xl">
                        <a href="{{ $popularPost->postUrl() }}"
                           class="before:absolute before:inset-0">
                            {{ $popularPost->title }}
                        </a>
                    </h2>
                    @if($popularPost->excerpt)
                        <p class="mb-6 line-clamp-3 text-sm font-medium leading-relaxed text-[var(--color-text-secondary)] opacity-80">
                            {{ $popularPost->excerpt }}
                        </p>
                    @endif
                    <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">
                        <span>{{ optional($popularPost->published_at)->translatedFormat('d F Y') }}</span>
                        <span>·</span>
                        <span>{{ number_format($popularPost->views_count) }} Pembaca</span>
                    </div>
                </div>
            </article>
        </section>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════════
         ALL ARTICLES GRID
    ══════════════════════════════════════════════════════════════════════ --}}
    <section class="pt-12">

        {{-- Section Header --}}
        <div class="mb-8 flex items-end justify-between border-b-4 border-[var(--color-text-primary)] pb-4">
            <div class="flex items-center gap-4">
                <div class="h-4 w-4 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                <h2 class="text-2xl font-black uppercase tracking-tighter text-[var(--color-text-primary)] md:text-4xl">
                    Semua Artikel
                </h2>
            </div>
            <span class="hidden text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-text-secondary)] opacity-50 md:block">
                {{ $posts->total() }} Publikasi
            </span>
        </div>

        @if($posts->isEmpty())
            <div class="border-4 border-[var(--color-border)] py-24 text-center">
                <p class="text-sm font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-40">
                    Penulis ini belum mempublikasikan artikel.
                </p>
            </div>
        @else
            {{-- Article List --}}
            <div class="flex flex-col gap-0">
                @foreach($posts as $index => $post)
                    @php $thumb = $post->getFirstMediaUrl('post_covers', 'thumb'); @endphp
                    <article class="group relative flex flex-col gap-0 border-b border-[var(--color-border)] py-8 last:border-b-0 sm:flex-row sm:gap-8">

                        {{-- Article Number --}}
                        <div class="hidden shrink-0 items-start pt-1 sm:flex">
                            <span class="w-8 text-right font-serif text-3xl font-black leading-none text-[var(--color-text-primary)] opacity-10 transition-opacity duration-300 group-hover:opacity-40">
                                {{ str_pad(($posts->currentPage() - 1) * $posts->perPage() + $index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        {{-- Thumbnail --}}
                        @if($thumb)
                            <a href="{{ $post->postUrl() }}"
                               class="block w-full shrink-0 overflow-hidden border border-[var(--color-border)] sm:w-40 sm:aspect-[4/3]">
                                <img src="{{ $thumb }}"
                                     alt="{{ $post->title }}"
                                     loading="lazy"
                                     decoding="async"
                                     width="400" height="300"
                                     class="aspect-video h-full w-full object-cover grayscale transition-all duration-500 group-hover:scale-105 group-hover:grayscale-0 sm:aspect-auto">
                            </a>
                        @else
                            <div class="hidden w-40 shrink-0 items-center justify-center border border-[var(--color-border)] bg-[var(--color-bg-secondary)] sm:flex sm:aspect-[4/3]">
                                <div class="h-4 w-4 rotate-45 bg-[var(--color-border)]"></div>
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="flex flex-1 flex-col justify-center">
                            <div class="mb-3 flex flex-wrap items-center gap-3">
                                @if($post->category)
                                    <a href="{{ route('blog.category', $post->category->slug) }}"
                                       class="inline-flex items-center gap-1.5 bg-[var(--color-accent-secondary)] px-2.5 py-0.5 text-[10px] font-black uppercase tracking-[0.2em] text-white no-underline transition-opacity hover:opacity-80">
                                        <div class="h-1 w-1 rotate-45 bg-white"></div>
                                        {{ $post->category->name }}
                                    </a>
                                @endif
                                <time class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60"
                                      datetime="{{ $post->published_at?->toDateString() }}">
                                    {{ optional($post->published_at)->translatedFormat('d F Y') }}
                                </time>
                            </div>

                            <h3 class="mb-3 text-xl font-black uppercase leading-tight tracking-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)] md:text-2xl">
                                <a href="{{ $post->postUrl() }}"
                                   class="after:absolute after:inset-0">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            @if($post->excerpt)
                                <p class="line-clamp-2 text-sm font-medium leading-relaxed text-[var(--color-text-secondary)] opacity-70">
                                    {{ $post->excerpt }}
                                </p>
                            @endif

                            <div class="mt-3 flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-50">
                                <span>{{ number_format($post->views_count) }} Pembaca</span>
                                @if($post->tags->isNotEmpty())
                                    <span>·</span>
                                    <span class="truncate max-w-[200px]">
                                        {{ $post->tags->take(2)->pluck('name')->join(', ') }}
                                    </span>
                                @endif
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-10 border-t-4 border-[var(--color-text-primary)] pt-8">
                <x-pagination :paginator="$posts" />
            </div>
        @endif

    </section>

@endsection
