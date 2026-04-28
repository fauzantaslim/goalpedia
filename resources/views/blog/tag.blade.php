@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Tag'],
        ['label' => $tag->name],
    ]" />

    <header class="relative mb-14 overflow-hidden border-b-8 border-[var(--color-text-primary)] pb-10 pt-12">
        <div class="pointer-events-none absolute right-0 top-0 flex h-full items-end gap-2 opacity-[0.04]" aria-hidden="true">
            <div class="h-full w-12 -skew-x-6 bg-[var(--color-accent-secondary)]"></div>
            <div class="h-3/4 w-8 -skew-x-6 bg-[var(--color-accent-primary)]"></div>
        </div>
        <div class="mb-4 flex items-center gap-4">
            <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
            <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[var(--color-accent-secondary)]">Arsip Tag</p>
        </div>
        <h1 class="text-5xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] md:text-7xl lg:text-[90px]">
            <span class="text-[var(--color-accent-secondary)]">#</span>{{ $tag->name }}
        </h1>
    </header>

    @if($posts->isEmpty())
        <div class="border-4 border-[var(--color-border)] py-20 text-center">
            <p class="text-sm font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-50">Belum ada artikel dengan tag ini.</p>
            <a href="{{ route('blog.home') }}" class="mt-6 inline-flex h-12 items-center border-2 border-[var(--color-text-primary)] bg-[var(--color-text-primary)] px-8 text-xs font-black uppercase tracking-widest text-[var(--color-bg-primary)] transition-colors hover:bg-transparent hover:text-[var(--color-text-primary)]">Ke Beranda</a>
        </div>
    @else
    <div class="lg:grid lg:grid-cols-[1fr_320px] lg:gap-12 border-t-8 border-[var(--color-text-primary)] pt-10">
        <div class="flex flex-col gap-8">
            @foreach($posts as $post)
                <article class="group flex flex-col md:flex-row gap-6 border-b border-[var(--color-border)] pb-8 last:border-b-0 last:pb-0">
                    @if($thumb = $post->getFirstMediaUrl('post_covers', 'thumb'))
                        <a href="{{ $post->postUrl() }}" 
                           class="block w-full md:w-1/3 shrink-0 aspect-[4/3] overflow-hidden border border-[var(--color-border)] shadow-sm">
                            <img src="{{ $thumb }}" alt="{{ $post->title }}" loading="lazy" decoding="async"
                                 class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale hover:grayscale-0">
                        </a>
                    @else
                        <div class="w-full md:w-1/3 shrink-0 aspect-[4/3] bg-[var(--color-bg-secondary)] opacity-10 flex items-center justify-center border border-[var(--color-border)] shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-8 w-8 text-[var(--color-text-secondary)] opacity-50" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                        </div>
                    @endif

                    <div class="flex flex-col justify-center">
                        <div class="mb-2 flex flex-wrap items-center gap-3">
                            @if($post->category)
                                <a href="{{ route('blog.category', $post->category->slug) }}"
                                   class="bg-[var(--color-accent-primary)] text-[var(--color-bg-primary)] px-2 py-0.5 text-[10px] font-black uppercase tracking-widest hover:bg-[var(--color-accent-secondary)] transition-colors">
                                    {{ $post->category->name }}
                                </a>
                            @endif
                            <time class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-70">
                                {{ optional($post->published_at)->diffForHumans() }}
                            </time>
                        </div>
                        <h3 class="mb-3 text-2xl font-black leading-tight tracking-tight text-[var(--color-text-primary)] group-hover:text-[var(--color-accent-primary)] transition-colors">
                            <a href="{{ $post->postUrl() }}" class="no-underline">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-[var(--color-text-secondary)] opacity-80">
                            {{ $post->excerpt }}
                        </p>
                        <div class="mt-auto flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">
                            <span>OLEH {{ $post->user?->name ?? 'REDAKSI' }}</span>
                        </div>
                    </div>
                </article>
            @endforeach

            <div class="mt-8">
                <x-pagination :paginator="$posts" />
            </div>
        </div>

        <aside class="mt-16 lg:mt-0">
            <div class="h-full space-y-12">
                @if(isset($popularPosts) && $popularPosts->isNotEmpty())
                <div class="sticky top-24">
                    <h3 class="mb-6 flex items-center gap-3 text-xs font-black uppercase tracking-[0.25em] text-[var(--color-accent-secondary)]">
                        <span class="h-px w-8 bg-[var(--color-accent-secondary)]"></span>
                        Terpopuler
                    </h3>
                    <div class="space-y-5">
                        @foreach($popularPosts->take(5) as $i => $pop)
                            <a href="{{ $pop->postUrl() }}" 
                               class="group flex items-start gap-4 no-underline">
                                <span class="text-2xl font-black italic text-[var(--color-accent-primary)] opacity-10 transition-colors group-hover:text-[var(--color-accent-secondary)] group-hover:opacity-30">
                                    {{ $i + 1 }}
                                </span>
                                <div class="relative h-[48px] w-[64px] shrink-0 overflow-hidden rounded-lg bg-[var(--color-border)] opacity-40">
                                    @if($pCover = $pop->getFirstMediaUrl('post_covers', 'thumb'))
                                        <img src="{{ $pCover }}" alt="{{ $pop->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[0.8rem] font-bold leading-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                                        {{ $pop->title }}
                                    </p>
                                    <p class="mt-1.5 text-[9px] font-bold tracking-widest text-[var(--color-text-secondary)] opacity-60 uppercase">
                                        {{ number_format($pop->views_count) }} Views
                                    </p>
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
