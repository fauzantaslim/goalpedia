@extends('layouts.app')

@section('content')

            <div class="mx-auto max-w-7xl">
                <x-breadcrumbs :links="array_filter([
        $post->category && $post->category->parent ? ['label' => $post->category->parent->name, 'url' => route('blog.category', $post->category->parent->slug)] : null,
        $post->category ? ['label' => $post->category->name, 'url' => route('blog.category', $post->category->slug)] : null,
        ['label' => $post->title],
    ])" />

                <div class="lg:grid lg:grid-cols-[1fr_320px] lg:gap-12">

                    {{-- MAIN ARTICLE COLUMN --}}
                    <article>
                        {{-- Meta --}}
                        <div class="mb-6 flex flex-wrap items-center gap-x-4 gap-y-2">
                            @if($post->category)
                                <a href="{{ route('blog.category', $post->category->slug) }}"
                                   class="inline-flex items-center gap-1.5 bg-[var(--color-accent-secondary)] px-3 py-1 text-[10px] font-black uppercase tracking-[0.25em] text-white no-underline transition-opacity hover:opacity-80">
                                    <div class="h-1.5 w-1.5 rotate-45 bg-white"></div>
                                    {{ $post->category->name }}
                                </a>
                            @endif
                            <time class="text-[11px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-70" datetime="{{ optional($post->published_at)->toIso8601String() }}">
                                {{ optional($post->published_at)->translatedFormat('d F Y, H:i') }}
                            </time>
                            @if($post->updated_at && $post->updated_at->gt($post->published_at))
                                <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-accent-secondary)] opacity-70">&bull; Diperbarui: {{ $post->updated_at->translatedFormat('d F Y, H:i') }}</span>
                            @endif
                        </div>

                        {{-- Title --}}
                        <h1 class="mb-8 text-4xl font-black uppercase leading-[1.0] tracking-tighter text-[var(--color-text-primary)] md:text-6xl lg:text-7xl">
                            {{ $post->title }}
                        </h1>

                        {{-- Author bar --}}
                        <div class="mb-10 flex items-center justify-between gap-3 border-y-2 border-[var(--color-text-primary)] py-4">
                            {{-- Author info --}}
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center bg-[var(--color-text-primary)] text-sm font-black text-[var(--color-bg-primary)]">
                                    {{ Str::upper(Str::substr($post->user?->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="flex flex-wrap items-baseline gap-x-2 gap-y-0.5">
                                    <a href="{{ route('blog.author', $post->user?->name) }}"
                                       class="text-sm font-black uppercase tracking-wider text-[var(--color-text-primary)] no-underline transition-colors hover:text-[var(--color-accent-secondary)]">
                                        {{ $post->user?->name }}
                                    </a>
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">&middot; {{ number_format($post->views_count) }} Pembaca</span>
                                </div>
                            </div>

                            {{-- Share button + dropdown --}}
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        aria-label="Bagikan artikel ini"
                                        title="Bagikan artikel"
                                        class="flex h-9 w-9 items-center justify-center rounded-full border border-border text-text-secondary opacity-80 transition-all hover:border-accent-secondary hover:bg-accent-secondary hover:text-accent-primary hover:opacity-100"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    {{-- Twitter / X --}}
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}"
                                       target="_blank" rel="noopener"
                                       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-bg-primary no-underline transition-colors hover:bg-accent-secondary hover:color-bg-primary">
                                        <svg class="h-4 w-4 shrink-0 fill-current" viewBox="0 0 24 24">
                                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622 5.911-5.622Zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                        </svg>
                                        Bagikan di X
                                    </a>

                                    {{-- WhatsApp --}}
                                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . request()->url()) }}"
                                       target="_blank" rel="noopener"
                                       class="flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-bg-primary no-underline transition-colors hover:bg-accent-secondary hover:color-bg-primary">
                                        <svg class="h-4 w-4 shrink-0 fill-current" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/>
                                        </svg>
                                        Bagikan via WA
                                    </a>

                                    <div class="my-1 border-t border-bg-primary/20"></div>

                                    {{-- Copy Link --}}
                                    <button
                                        @click="navigator.clipboard.writeText('{{ request()->url() }}').then(() => { $dispatch('close') })"
                                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm font-semibold text-bg-primary transition-colors hover:bg-accent-secondary hover:color-bg-primary">
                                        <svg class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                        Salin Tautan
                                    </button>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        {{-- Cover Image --}}
                        @if($cover = $post->getFirstMediaUrl('post_covers', 'optimized'))
                            <figure class="mb-12">
                                <a data-fancybox="gallery" data-caption="{{ $post->title_cover ?? $post->title }}" href="{{ $post->getFirstMediaUrl('post_covers') }}" class="block border-2 border-[var(--color-text-primary)]">
                                    <img src="{{ $cover }}" alt="{{ $post->title }}" title="{{ $post->title_cover ?? $post->title }}" fetchpriority="high"
                                         width="1200" height="630"
                                         class="w-full object-cover cursor-zoom-in transition-opacity hover:opacity-95">
                                </a>
                                @if($post->title_cover)
                                    <figcaption class="border-x-2 border-b-2 border-[var(--color-text-primary)] bg-[var(--color-bg-secondary)]/30 px-4 py-3 sm:px-6">
                                        <div class="flex items-start justify-center gap-2 md:gap-3">
                                            <div class="mt-1.5 h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--color-accent-secondary)] hidden md:block"></div>
                                            <p class="text-center text-[11px] font-medium leading-relaxed text-[var(--color-text-secondary)] md:text-xs">
                                                {{ $post->title_cover }}
                                            </p>
                                        </div>
                                    </figcaption>
                                @endif
                            </figure>
                        @endif

                        {{-- Content with Baca Juga injection --}}
                        @php
                            $bacaJugaHtml = '';
                            if ($relatedPosts->isNotEmpty()) {
                                $relatedList = '';
                                foreach ($relatedPosts->take(2) as $relatedPost) {
                                    $url = $relatedPost->postUrl();
                                    $img = $relatedPost->getFirstMediaUrl('post_covers', 'thumb');
                                    $imgHtml = $img
                                        ? '<div class="shrink-0 w-24 h-24 sm:w-32 sm:h-24 overflow-hidden border border-[var(--color-border)]"><img src="' . $img . '" alt="' . htmlspecialchars($relatedPost->title) . '" loading="lazy" decoding="async" class="h-full w-full object-cover grayscale transition-transform duration-500 group-hover/bj:scale-110 group-hover/bj:grayscale-0"></div>'
                                        : '<div class="shrink-0 w-24 h-24 sm:w-32 sm:h-24 border border-[var(--color-border)] bg-[var(--color-bg-secondary)] opacity-10 flex items-center justify-center"></div>';
                                    $title = htmlspecialchars($relatedPost->title);
                                    $relatedList .= '<a href="' . $url . '" class="group/bj flex items-start gap-4 sm:gap-6 no-underline border-b border-[var(--color-border)] pb-5 last:border-0 last:pb-0">' . $imgHtml . '<h4 class="text-base sm:text-xl font-black leading-tight tracking-tight text-[var(--color-text-primary)] transition-colors group-hover/bj:text-[var(--color-accent-primary)]">' . $title . '</h4></a>';
                                }
                                $bacaJugaHtml = '
                                                                <div class="not-prose my-14 border-y-4 border-[var(--color-text-primary)] py-8 font-sans">
                                                                    <div class="mb-6 flex items-center gap-3">

                                                                        <p class="text-[11px] font-black uppercase tracking-[0.3em] text-[var(--color-accent-secondary)]">
                                                                        Baca Juga</p>
                                                                    </div>
                                                                    <div class="flex flex-col gap-6">' . $relatedList . '</div>
                                                                </div>';

                                $content = $post->content;

                                // Modifikasi gambar dalam konten untuk Fancybox dan Caption
                                $content = preg_replace_callback('/(<p>\s*)?(<img\s+[^>]+>)(\s*<\/p>)?/i', function($matches) {
                                    $imgHtml = $matches[2];

                                    preg_match('/src=["\']([^"\']+)["\']/i', $imgHtml, $srcMatch);
                                    $src = $srcMatch[1] ?? '';

                                    preg_match('/alt=["\']([^"\']*)["\']/i', $imgHtml, $altMatch);
                                    $alt = $altMatch[1] ?? '';

                                    if (empty($src)) {
                                        return $matches[0];
                                    }

                                    $captionHtml = '';
                                    if (!empty($alt)) {
                                        $captionHtml = '
                                            <figcaption class="border-x-2 border-b-2 border-[var(--color-text-primary)] bg-[var(--color-bg-secondary)]/30 px-4 py-3 sm:px-6">
                                                <div class="flex items-start justify-center gap-2 md:gap-3">
                                                    <div class="mt-1.5 h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--color-accent-secondary)] hidden md:block"></div>
                                                    <p class="not-prose text-center text-[11px] font-medium leading-relaxed text-[var(--color-text-secondary)] md:text-xs">
                                                        ' . htmlspecialchars($alt) . '
                                                    </p>
                                                </div>
                                            </figcaption>';
                                    }

                                    $imgHtmlClean = preg_replace('/class=["\'][^"\']*["\']/i', '', $imgHtml);
                                    $imgHtmlClean = str_replace('<img ', '<img width="1200" height="630" class="w-full object-cover cursor-zoom-in transition-opacity hover:opacity-95 m-0" ', $imgHtmlClean);

                                    return '
                                        <figure class="my-12 flex flex-col">
                                            <a data-fancybox="gallery" data-caption="' . htmlspecialchars($alt) . '" href="' . $src . '" class="block border-2 border-[var(--color-text-primary)]">
                                                ' . $imgHtmlClean . '
                                            </a>
                                            ' . $captionHtml . '
                                        </figure>
                                    ';
                                }, $content);

                                $pCount = substr_count($content, '</p>');
                                $insertAt = $pCount >= 8 ? intval($pCount / 2) : ($pCount >= 4 ? 3 : 2);

                                if ($pCount >= $insertAt) {
                                    $content = preg_replace('/((?:.*?<\/p>){' . $insertAt . '})/s', '$1' . $bacaJugaHtml, $content, 1);
                                } else {
                                    $content .= $bacaJugaHtml;
                                }
                            } else {
                                $content = $post->content;
                                // Modifikasi gambar juga untuk post tanpa "Baca Juga"
                                $content = preg_replace_callback('/(<p>\s*)?(<img\s+[^>]+>)(\s*<\/p>)?/i', function($matches) {
                                    $imgHtml = $matches[2];
                                    preg_match('/src=["\']([^"\']+)["\']/i', $imgHtml, $srcMatch);
                                    $src = $srcMatch[1] ?? '';
                                    preg_match('/alt=["\']([^"\']*)["\']/i', $imgHtml, $altMatch);
                                    $alt = $altMatch[1] ?? '';

                                    if (empty($src)) return $matches[0];

                                    $captionHtml = '';
                                    if (!empty($alt)) {
                                        $captionHtml = '<figcaption class="border-x-2 border-b-2 border-[var(--color-text-primary)] bg-[var(--color-bg-secondary)]/30 px-4 py-3 sm:px-6"><div class="flex items-start justify-center gap-2 md:gap-3"><div class="mt-1.5 h-1.5 w-1.5 shrink-0 rotate-45 bg-[var(--color-accent-secondary)] hidden md:block"></div><p class="not-prose text-center text-[11px] font-medium leading-relaxed text-[var(--color-text-secondary)] md:text-xs">' . htmlspecialchars($alt) . '</p></div></figcaption>';
                                    }

                                    $imgHtmlClean = preg_replace('/class=["\'][^"\']*["\']/i', '', $imgHtml);
                                    $imgHtmlClean = str_replace('<img ', '<img class="w-full object-cover cursor-zoom-in transition-opacity hover:opacity-95 m-0" ', $imgHtmlClean);

                                    return '<figure class="my-12 flex flex-col"><a data-fancybox="gallery" data-caption="' . htmlspecialchars($alt) . '" href="' . $src . '" class="block border-2 border-[var(--color-text-primary)]">' . $imgHtmlClean . '</a>' . $captionHtml . '</figure>';
                                }, $content);
                            }
                        @endphp

                        <div class="prose max-w-none leading-relaxed
                            prose-headings:font-black prose-headings:tracking-tight prose-headings:text-text-primary
                            prose-p:text-text-secondary prose-p:leading-8 prose-p:mb-6
                            prose-strong:text-text-primary
                            prose-a:text-accent-secondary prose-a:no-underline hover:prose-a:underline
                            prose-blockquote:border-l-accent-secondary prose-blockquote:bg-bg-secondary/10 prose-blockquote:py-2 prose-blockquote:px-6 prose-blockquote:rounded-r-xl prose-blockquote:not-italic prose-blockquote:text-text-primary
                            prose-li:text-text-secondary
                            md:prose-lg">
                            {!! $content !!}
                        </div>

                        {{-- FAQ SECTION --}}
                        @if($post->faqs->isNotEmpty())
                            <div class="mt-16 border-t border-border pt-12">
                                <div class="mb-8">
                                    <h2 class="text-2xl font-black tracking-tight text-text-primary md:text-3xl">Pertanyaan yang Sering <span class="text-accent-secondary">Diajukan</span></h2>
                                    <p class="mt-2 text-sm text-text-secondary/70">Punya pertanyaan? Mungkin jawaban di bawah ini bisa membantu Anda.</p>
                                </div>

                                <div class="space-y-4" x-data="{ active: null }">
                                    @foreach($post->faqs as $faq)
                                        <div class="overflow-hidden rounded-lg border border-border bg-bg-secondary/5 transition-all">
                                            <button
                                                @click="active !== {{ $faq->id }} ? active = {{ $faq->id }} : active = null"
                                                class="flex w-full items-center justify-between p-5 text-left transition-colors hover:bg-bg-secondary/10"
                                                :class="{ 'bg-bg-secondary/10': active === {{ $faq->id }} }"
                                            >
                                                <span class="pr-4 text-sm font-bold text-text-primary md:text-base">{{ $faq->question }}</span>
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5 shrink-0 text-accent-secondary transition-transform duration-300"
                                                    :class="{ 'rotate-180': active === {{ $faq->id }} }"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                >
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>

                                            <div
                                                x-show="active === {{ $faq->id }}"
                                                x-collapse
                                                style="display: none;"
                                            >
                                                <div class="border-t border-border p-5 pt-4 text-sm leading-relaxed text-text-secondary md:text-base">
                                                    {!! nl2br(e($faq->answer)) !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Tags --}}
                        @if($post->tags->isNotEmpty())
                            <div class="mt-12 flex flex-wrap gap-2 border-t border-border pt-8">
                                @foreach($post->tags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}"
                                       class="rounded-full border border-border bg-bg-primary/50 px-4 py-1.5 text-xs font-medium text-text-secondary no-underline transition-all hover:border-accent-secondary hover:bg-accent-secondary hover:text-accent-primary hover:opacity-100">
                                        #{{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        {{-- Terbaru Lainnya Section --}}
                        @if($latestPosts->isNotEmpty())
                            <div class="mt-16 border-t-8 border-[var(--color-text-primary)] pt-12">
                                <div class="mb-8 border-b-4 border-[var(--color-text-primary)] pb-2">
                                    <h2 class="text-3xl font-black uppercase tracking-widest text-[var(--color-text-primary)]">Artikel Terkini</h2>
                                </div>

                                <div class="flex flex-col gap-8">
                                    @foreach($latestPosts as $lPost)
                                        <article class="group flex flex-col md:flex-row gap-6 border-b border-[var(--color-border)] pb-8 last:border-b-0 last:pb-0">
                                            @if($lCover = $lPost->getFirstMediaUrl('post_covers', 'thumb'))
                                                <a href="{{ $lPost->postUrl() }}" 
                                                   class="block w-full md:w-1/3 shrink-0 aspect-[4/3] overflow-hidden border border-[var(--color-border)] shadow-sm">
                                                    <img src="{{ $lCover }}" alt="{{ $lPost->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105 grayscale hover:grayscale-0">
                                                </a>
                                            @else
                                                <div class="w-full md:w-1/3 shrink-0 aspect-[4/3] bg-[var(--color-bg-secondary)] opacity-10 flex items-center justify-center border border-[var(--color-border)] shadow-sm"></div>
                                            @endif

                                            <div class="flex flex-col justify-center">
                                                <div class="mb-2 flex flex-wrap items-center gap-3">
                                                    @if($lPost->category)
                                                        <a href="{{ route('blog.category', $lPost->category->slug) }}"
                                                           class="bg-[var(--color-accent-primary)] text-[var(--color-bg-primary)] px-2 py-0.5 text-[10px] font-black uppercase tracking-widest hover:bg-[var(--color-accent-secondary)] transition-colors">
                                                            {{ $lPost->category->name }}
                                                        </a>
                                                    @endif
                                                    <time class="text-[10px] font-bold uppercase tracking-widest text-[var(--color-text-secondary)] opacity-70">
                                                        {{ optional($lPost->published_at)->diffForHumans() }}
                                                    </time>
                                                </div>
                                                <h3 class="mb-3 text-2xl font-black leading-tight tracking-tight text-[var(--color-text-primary)] group-hover:text-[var(--color-accent-primary)] transition-colors">
                                                    <a href="{{ $lPost->postUrl() }}" class="no-underline">
                                                        {{ $lPost->title }}
                                                    </a>
                                                </h3>
                                                <p class="mb-4 line-clamp-2 text-sm leading-relaxed text-[var(--color-text-secondary)] opacity-80">
                                                    {{ $lPost->excerpt }}
                                                </p>
                                                <div class="mt-auto flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] opacity-60">
                                                    <span>OLEH {{ $lPost->user?->name ?? 'REDAKSI' }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </article>

                    {{-- SIDEBAR COLUMN --}}
                    <aside class="mt-12 lg:mt-0">
                        <div class="h-full space-y-12">

                            {{-- Related in Category --}}
                            @if($relatedPosts->isNotEmpty())
                                <div>
                                    <h3 class="mb-6 flex items-center gap-3 border-b-2 border-accent-secondary pb-2 text-xs font-black uppercase tracking-widest text-text-primary">
                                        <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                                        {{ $post->category?->name ?? 'Berita' }} <span class="text-accent-secondary">Lainnya</span>
                                    </h3>
                                    <div class="divide-y divide-border">
                                        @foreach($relatedPosts as $r)
                                            <a href="{{ $r->postUrl() }}"
                                               class="group flex items-center gap-3 py-4 no-underline first:pt-0">
                                                {{-- Thumb --}}
                                                <div class="relative h-[60px] w-[80px] shrink-0 overflow-hidden rounded-lg bg-border/20">
                                                    @if($rCover = $r->getFirstMediaUrl('post_covers', 'thumb'))
                                                        <img src="{{ $rCover }}" alt="{{ $r->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110">
                                                    @else
                                                        <div class="flex h-full w-full items-center justify-center bg-border/10 text-[6px] font-bold uppercase tracking-tighter text-text-secondary/60">Finlogy</div>
                                                    @endif
                                                </div>
                                                <div class="flex min-w-0 flex-col">
                                                    <p class="mb-1.5 line-clamp-2 text-[0.8rem] font-bold leading-tight text-text-primary transition-colors group-hover:text-accent-secondary">
                                                        {{ $r->title }}
                                                    </p>
                                                    <time class="text-[9px] font-bold uppercase tracking-wider text-text-secondary/40">
                                                        {{ optional($r->published_at)->translatedFormat('d M Y') }}
                                                    </time>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Popular Posts (Sticky) --}}
                            @if($popularPosts->isNotEmpty())
                                <div class="sticky top-24">
                                    <h3 class="mb-6 flex items-center gap-3 border-b-2 border-accent-secondary pb-2 text-xs font-black uppercase tracking-widest text-text-primary">
                                        <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                                        Blog <span class="text-accent-secondary">Terpopuler</span>
                                    </h3>
                                    <div class="space-y-4">
                                        @foreach($popularPosts as $i => $pop)
                                            <a href="{{ $pop->postUrl() }}"
                                               class="group flex items-start gap-3 no-underline">
                                                <span class="mt-0.5 shrink-0 text-xl font-black leading-none text-accent-secondary/20 transition-colors group-hover:text-accent-secondary group-hover:opacity-100">
                                                    {{ $i + 1 }}
                                                </span>
                                                {{-- Mini Thumb for Popular --}}
                                                <div class="relative h-[44px] w-[58px] shrink-0 overflow-hidden rounded bg-border/20">
                                                    @if($pCover = $pop->getFirstMediaUrl('post_covers', 'thumb'))
                                                        <img src="{{ $pCover }}" alt="{{ $pop->title }}" loading="lazy" decoding="async" class="h-full w-full object-cover opacity-80 group-hover:opacity-100 transition-opacity">
                                                    @else
                                                        <div class="h-full w-full bg-border/10"></div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="line-clamp-2 text-[0.75rem] font-bold leading-tight text-text-primary transition-colors group-hover:text-accent-secondary">
                                                        {{ $pop->title }}
                                                    </p>
                                                    <div class="mt-1 flex items-center gap-2 text-[8px] font-bold uppercase tracking-widest text-text-secondary/30">
                                                        <span>{{ optional($pop->published_at)->translatedFormat('d M Y') }}</span>
                                                        <span>&middot;</span>
                                                        <span>{{ number_format($pop->views_count) }} Views</span>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </aside>
                </div>
            </div>

@endsection
