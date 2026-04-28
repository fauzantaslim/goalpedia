@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Pencarian'],
        ['label' => $query ?? 'Hasil'],
    ]" />

    <header class="relative mb-10 overflow-hidden border-b-8 border-[var(--color-text-primary)] pb-10 pt-12">
        <div class="pointer-events-none absolute right-0 top-0 flex h-full items-end gap-2 opacity-[0.04]" aria-hidden="true">
            <div class="h-full w-12 -skew-x-6 bg-[var(--color-accent-secondary)]"></div>
        </div>
        <div class="mb-4 flex items-center gap-4">
            <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
            <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[var(--color-accent-secondary)]">Hasil Pencarian</p>
        </div>
        <h1 class="text-4xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] md:text-6xl">
            "{{ $query }}"
        </h1>
        <p class="mt-4 border-l-4 border-[var(--color-accent-secondary)] pl-4 text-sm font-semibold text-[var(--color-text-secondary)]">
            Menampilkan <strong class="text-[var(--color-text-primary)]">{{ $posts->total() }}</strong> artikel yang cocok.
        </p>

        @if(!empty($suggestion))
            <p class="mt-4 text-sm font-semibold text-[var(--color-text-secondary)]">
                Mungkin maksud Anda: 
                <a href="{{ route('blog.search', ['q' => $suggestion]) }}" class="text-[var(--color-accent-primary)] hover:text-[var(--color-accent-secondary)] font-bold italic underline decoration-[var(--color-accent-primary)]/30 underline-offset-4">
                    {{ $suggestion }}
                </a>?
            </p>
        @endif
    </header>

    <section class="flex flex-col gap-8 border-t-8 border-[var(--color-text-primary)] pt-8">
        @forelse($posts as $post)
            <article class="group flex flex-col sm:flex-row gap-6 pb-8 border-b border-[var(--color-border)] last:border-0 last:pb-0">
                @if($thumb = $post->getFirstMediaUrl('post_covers', 'thumb'))
                    <a href="{{ $post->postUrl() }}" class="block w-full sm:w-1/3 md:w-1/4 shrink-0 aspect-video sm:aspect-[4/3] overflow-hidden border border-[var(--color-border)] shadow-sm">
                        <img src="{{ $thumb }}" alt="{{ $post->title }}" loading="lazy" decoding="async"
                             class="h-full w-full object-cover grayscale transition-transform duration-500 group-hover:scale-105 group-hover:grayscale-0">
                    </a>
                @else
                    <div class="block w-full sm:w-1/3 md:w-1/4 shrink-0 aspect-video sm:aspect-[4/3] bg-[var(--color-bg-secondary)] opacity-10 flex items-center justify-center border border-[var(--color-border)] shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-8 w-8 text-[var(--color-text-secondary)] opacity-20" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </div>
                @endif

                <div class="flex flex-1 flex-col justify-center">
                    <div class="mb-3 flex flex-wrap items-center gap-3">
                        @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}"
                               class="bg-[var(--color-accent-primary)] px-2 py-0.5 text-[10px] font-black uppercase tracking-widest text-[var(--color-bg-primary)] hover:bg-[var(--color-accent-secondary)] transition-colors">
                                {{ $post->category->name }}
                            </a>
                        @endif
                        <time class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60" datetime="{{ $post->published_at?->toDateString() }}">
                            {{ optional($post->published_at)->diffForHumans() }}
                        </time>
                    </div>
                    <h2 class="mb-3 text-2xl font-black leading-tight tracking-tight text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                        <a href="{{ $post->postUrl() }}" class="no-underline">
                            {{ $post->title }}
                        </a>
                    </h2>
                    <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-[var(--color-text-secondary)] opacity-80">
                        {{ $post->excerpt }}
                    </p>
                    <div class="mt-auto flex items-center gap-3">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">OLEH {{ $post->user?->name ?? 'REDAKSI' }}</span>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center">
                <div class="mb-6 inline-flex h-20 w-20 items-center justify-center border-4 border-[var(--color-text-primary)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[var(--color-text-primary)]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </div>
                <h3 class="mb-2 text-2xl font-black uppercase tracking-tighter text-[var(--color-text-primary)]">Tidak Ada Hasil</h3>
                <p class="mt-2 max-w-xs mx-auto text-sm font-medium text-[var(--color-text-secondary)] opacity-70">Coba kata kunci lain atau lihat semua artikel di halaman utama.</p>
                <a href="{{ route('blog.home') }}" class="mt-8 inline-flex h-12 items-center border-2 border-[var(--color-text-primary)] bg-[var(--color-text-primary)] px-8 text-xs font-black uppercase tracking-widest text-[var(--color-bg-primary)] transition-colors hover:bg-transparent hover:text-[var(--color-text-primary)]">
                    Ke Beranda
                </a>
            </div>
        @endforelse
    </section>

    <div class="mt-12">
        <x-pagination :paginator="$posts" />
    </div>

@endsection
