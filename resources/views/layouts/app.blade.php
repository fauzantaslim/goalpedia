<!doctype html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
        dark: localStorage.getItem('theme') === 'dark',
        searchOpen: false,
        menuOpen: false
    }"
    x-init="$watch('dark', val => localStorage.setItem('theme', val ? 'dark' : 'light'))"
    :class="{ 'dark': dark }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="#FFFCFB" />
    <meta name="theme-color" media="(prefers-color-scheme: dark)" content="#093FB4" />
    {!! \Artesaos\SEOTools\Facades\SEOTools::generate() !!}
    @googlefonts('poppins')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body
    class="bg-[var(--color-bg-primary)] font-sans text-[var(--color-text-primary)]"
    @keydown.escape.window="searchOpen = false; menuOpen = false"
>
    <div class="flex min-h-screen flex-col">


            {{-- 1. TOP LAYER: Toggle | Logo | Socials --}}
            <div class="hidden md:block w-full bg-[var(--color-bg-primary)] border-b border-[var(--color-border)] py-4">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6">
                    {{-- Left: Theme Toggle --}}
                    <button
                        @click="dark = !dark"
                        title="Toggle tema"
                        aria-label="Toggle tema gelap atau terang"
                        class="group relative flex h-7 w-[52px] shrink-0 cursor-pointer items-center rounded-full p-0.5 transition-all duration-300"
                        :class="dark ? 'bg-color-bg-primary border border-[#ffb000]/60 hover:border-[#ffb000]' : 'bg-[#E8E4B8] border border-[#d4c97a] hover:border-[var(--color-accent-secondary)]'"
                    >
                        {{-- Sliding thumb --}}
                        <span
                            class="relative flex h-6 w-6 shrink-0 items-center justify-center rounded-full shadow-sm transition-all duration-300"
                            :class="dark ? 'translate-x-[24px] bg-[var(--color-accent-secondary)]' : 'translate-x-0 bg-[var(--color-accent-primary)]'"
                        >
                            {{-- Sun icon (light mode) --}}
                            <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#f5f3dc]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                            </svg>
                            {{-- Moon icon (dark mode) --}}
                            <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#004225]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                            </svg>
                        </span>
                    </button>

                    {{-- Center: Logo --}}
                    <a href="{{ route('blog.home') }}" aria-label="Halaman Utama {{ $settings->site_name }}" class="group flex items-center justify-center no-underline">
                        @if($logoLarge = $settings->logo_large_url)
                            <img src="{{ $logoLarge }}" alt="Logo {{ $settings->site_name }}" fetchpriority="high" width="200" height="64" class="h-20 md:h-24 w-auto transition-all hover:scale-[1.02]" :class="{ 'brightness-0 invert': dark }">
                        @else
                            <span class="text-3xl font-black italic tracking-tighter text-[var(--color-accent-primary)] md:text-4xl transition-transform hover:scale-[1.02]">
                                {{ Str::lower($settings->site_name) }}<span class="text-[var(--color-accent-secondary)]">.id</span>
                            </span>
                        @endif
                    </a>

                    {{-- Right: Social Icons --}}
                    <div class="flex items-center gap-5 text-[var(--color-text-primary)]/80">
                        @if($settings->x_url)
                        <a href="{{ $settings->x_url }}" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi X (Twitter)" class="hover:text-[var(--color-accent-primary)]">
                            <svg class="h-4 w-4 fill-current" aria-hidden="true" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        @endif
                        @if($settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi Facebook" class="hover:text-[var(--color-accent-primary)]">
                            <svg class="h-4 w-4 fill-current" aria-hidden="true" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03.284-2 1.5-2h1.5V1.75c-.273-.037-1.215-.125-2.307-.125C12.42 1.625 10 3.12 10 6.5v3H7v4h3V22h4v-8.5z"/></svg>
                        </a>
                        @endif
                        @if($settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Kunjungi Instagram" class="hover:text-[var(--color-accent-primary)]">
                            <svg class="h-4 w-4 fill-current" aria-hidden="true" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.981 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                        </a>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 2. NAV BAR (Sticky) --}}
            <nav class="sticky top-0 z-50 border-b border-[var(--color-border)] bg-[var(--color-bg-primary)]/95 backdrop-blur-xl">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-4">
                    
                    {{-- --- MOBILE LAYOUT (Hidden on Desktop) --- --}}
                    <div class="flex w-full items-center justify-between md:hidden">
                        {{-- Left: Hamburger --}}
                        <div class="flex flex-1 justify-start">
                            <button @click="menuOpen = true" aria-expanded="false" aria-label="Buka menu navigasi" class="text-[var(--color-text-primary)] hover:text-[var(--color-accent-primary)] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>

                        {{-- Center: Logo --}}
                        <div class="flex flex-none justify-center">
                            <a href="{{ route('blog.home') }}" aria-label="Halaman Utama {{ $settings->site_name }}" class="flex items-center">
                                @if($logoLarge = $settings->logo_large_url)
                                    <img src="{{ $logoLarge }}" fetchpriority="high" alt="Logo {{ $settings->site_name }}" class="h-18 w-auto transition-all" :class="{ 'brightness-0 invert': dark }">
                                @else
                                    <span class="text-2xl font-black italic tracking-tighter text-[var(--color-accent-primary)]">
                                        {{ Str::lower($settings->site_name) }}<span class="text-[var(--color-accent-secondary)]">.id</span>
                                    </span>
                                @endif
                            </a>
                        </div>

                        {{-- Right: Search --}}
                        <div class="flex flex-1 justify-end">
                            <button @click="searchOpen = true" aria-expanded="false" aria-label="Buka form pencarian" class="text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- --- DESKTOP LAYOUT (Hidden on Mobile) --- --}}
                    <div class="hidden w-full items-center justify-between md:flex">
                        {{-- Left: Logo --}}
                        <a href="{{ route('blog.home') }}" aria-label="Halaman Utama {{ $settings->site_name }}" class="flex items-center">
                            @if($logoSmall = $settings->logo_small_url)
                                <img src="{{ $logoSmall }}" fetchpriority="high" alt="Logo {{ $settings->site_name }}" class="h-10 w-auto transition-all hover:opacity-80" :class="{ 'brightness-0 invert': dark }">
                            @else

                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-[var(--color-accent-primary)] text-white font-black italic shadow-lg shadow-[var(--color-accent-primary)]/20">
                                    {{ substr($settings->site_name, 0, 1) }}
                                </div>
                            @endif
                        </a>

                        {{-- Center: Nav Links --}}
                        <div class="flex flex-1 items-center justify-center gap-6 flex-wrap px-8">
                            <a href="{{ route('blog.home') }}"
                               class="shrink-0 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors @if(request()->routeIs('blog.home')) text-[var(--color-accent-secondary)] @endif">
                                Beranda
                            </a>
                            @foreach(($categories ?? collect())->whereNull('parent_id') as $navCategory)
                                @php $children = ($categories ?? collect())->where('parent_id', $navCategory->id); @endphp
                                @if($children->isNotEmpty())
                                    <div class="group relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                                        <a href="{{ route('blog.category', $navCategory->slug) }}"
                                           class="flex items-center gap-1 shrink-0 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors @if(request()->is('kategori/' . $navCategory->slug . '*')) text-[var(--color-accent-secondary)] @endif">
                                            {{ $navCategory->name }}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </a>
                                        <div x-show="open" x-transition class="absolute left-0 top-full pt-4 z-50 min-w-[200px]" style="display: none;">
                                            <div class="rounded-lg border border-[var(--color-border)] bg-[var(--color-bg-primary)] p-2 shadow-xl">
                                                @foreach($children as $child)
                                                    <a href="{{ route('blog.category', $child->slug) }}" class="block rounded-lg px-4 py-2 text-xs font-bold uppercase tracking-widest text-[var(--color-text-primary)] hover:bg-[var(--color-accent-primary)] hover:text-[var(--color-bg-primary)] transition-colors">
                                                        {{ $child->name }}
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('blog.category', $navCategory->slug) }}"
                                       class="shrink-0 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors @if(request()->is('kategori/' . $navCategory->slug . '*')) text-[var(--color-accent-secondary)] @endif">
                                        {{ $navCategory->name }}
                                    </a>
                                @endif
                            @endforeach
                        </div>

                        {{-- Right: Search --}}
                        <div class="flex items-center">
                            <button @click="searchOpen = true" aria-expanded="false" aria-label="Buka form pencarian" class="text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>
            </nav>


        {{-- SEARCH TOP DRAWER (Editorial Style) --}}
        <div
            x-show="searchOpen"
            style="display: none;"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-y-full"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="-translate-y-full"
            class="fixed left-0 right-0 top-0 z-[60] border-b-8 border-[var(--color-text-primary)] bg-[var(--color-bg-primary)] shadow-2xl"
        >
            <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-6 py-6 md:py-8">
                <div class="flex-1">
                    <p class="mb-2 text-[10px] font-black uppercase tracking-[0.4em] text-[var(--color-accent-secondary)]">Pencarian Editorial</p>
                    <form action="{{ route('blog.search') }}" method="GET" class="relative max-w-4xl">
                        <label for="search-input" class="sr-only">Cari artikel</label>
                        <input
                            id="search-input"
                            type="text" name="q"
                            placeholder="Ketik topik, tokoh, atau berita..."
                            class="w-full border-0 border-b-4 border-[var(--color-text-primary)] bg-transparent py-2 pl-0 pr-12 text-3xl font-black text-[var(--color-text-primary)] focus:border-[var(--color-accent-primary)] focus:outline-none focus:ring-0 md:text-5xl"
                            value="{{ request('q') }}"
                            x-ref="searchInput"
                            x-effect="if (searchOpen) $nextTick(() => $refs.searchInput.focus())"
                        >
                        <button type="submit" class="absolute bottom-4 right-2 text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-secondary)]">
                            <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-8 w-8 md:h-10 md:w-10" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <div class="ml-8 flex shrink-0 items-start justify-end">
                    <button @click="searchOpen = false" aria-label="Tutup form pencarian" class="text-[var(--color-text-primary)] transition-transform hover:scale-110 hover:text-[var(--color-accent-secondary)]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 md:h-12 md:w-12" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Search Backdrop --}}
        <div 
            x-show="searchOpen" 
            style="display: none;"
            @click="searchOpen = false"
            x-transition.opacity.duration.300ms
            class="fixed inset-0 z-[55] bg-black/40 backdrop-blur-sm"
        ></div>

        {{-- MOBILE MENU SIDEBAR --}}
        <div x-show="menuOpen" class="fixed inset-0 z-[100]" style="display: none;">
            {{-- Backdrop --}}
            <div
                @click="menuOpen = false"
                x-show="menuOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            ></div>

            {{-- Sidebar Content --}}
            <div
                x-show="menuOpen"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="absolute inset-y-0 left-0 flex w-full max-w-[300px] flex-col overflow-y-auto bg-[var(--color-bg-primary)] p-8 shadow-2xl"
            >
                <div class="flex items-center justify-between mb-12">
                    <a href="{{ route('blog.home') }}">
                        @if($settings->logo_small_url)
                            <img src="{{ $settings->logo_small_url }}" alt="{{ $settings->site_name }}" class="h-8 w-auto transition-all" :class="{ 'brightness-0 invert': dark }">
                        @else
                            <span class="text-xl font-black italic text-[var(--color-accent-primary)]">{{ Str::lower($settings->site_name) }}</span>
                        @endif
                    </a>
                    <div class="flex items-center gap-2">
                        {{-- Mobile theme toggle --}}
                        <button
                            @click="dark = !dark"
                            title="Toggle tema"
                            aria-label="Toggle tema gelap atau terang"
                            class="relative flex h-7 w-[52px] shrink-0 cursor-pointer items-center rounded-full p-0.5 transition-all duration-300"
                            :class="dark ? 'bg-[#1a3525] border border-[#ffb000]/60' : 'bg-[#e8e4b8] border border-[#d4c97a]'"
                        >
                            <span
                                class="relative flex h-6 w-6 shrink-0 items-center justify-center rounded-full shadow-sm transition-all duration-300"
                                :class="dark ? 'translate-x-[24px] bg-[var(--color-accent-secondary)]' : 'translate-x-0 bg-[var(--color-accent-primary)]'"
                            >
                                <svg x-show="!dark" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#f5f3dc]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
                                </svg>
                                <svg x-show="dark" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-[#004225]" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                </svg>
                            </span>
                        </button>
                        {{-- Close button --}}
                        <button @click="menuOpen = false" aria-label="Tutup menu navigasi" class="rounded-full border border-[var(--color-border)] p-2 hover:bg-[var(--color-border)] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Nav Links --}}
                <div class="flex flex-col gap-6">
                    <a href="{{ route('blog.home') }}"
                       class="text-xl font-black uppercase tracking-tight text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors @if(request()->routeIs('blog.home')) text-[var(--color-accent-secondary)] @endif">
                        Beranda
                    </a>
                    @foreach(($categories ?? collect())->whereNull('parent_id') as $navCategory)
                        @php $children = ($categories ?? collect())->where('parent_id', $navCategory->id); @endphp
                        @if($children->isNotEmpty())
                            <div x-data="{ expanded: false }">
                                <div class="flex items-center justify-between">
                                    <a href="{{ route('blog.category', $navCategory->slug) }}"
                                       class="text-xl font-black uppercase tracking-tight text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors">
                                        {{ $navCategory->name }}
                                    </a>
                                    <button @click="expanded = !expanded" class="p-2 text-[var(--color-text-primary)]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="expanded" x-collapse style="display: none;">
                                    <div class="flex flex-col gap-4 border-l-2 border-[var(--color-border)] pl-4 pt-4">
                                        @foreach($children as $child)
                                            <a href="{{ route('blog.category', $child->slug) }}"
                                               class="text-sm font-bold uppercase tracking-tight text-[var(--color-text-secondary)] hover:text-[var(--color-accent-secondary)] transition-colors">
                                                {{ $child->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('blog.category', $navCategory->slug) }}"
                               class="text-xl font-black uppercase tracking-tight text-[var(--color-text-primary)] hover:text-[var(--color-accent-secondary)] transition-colors">
                                {{ $navCategory->name }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Bottom Section: Socials --}}
                <div class="mt-auto pt-10 border-t border-[var(--color-border)]">
                    <div class="flex flex-col gap-4">
                        <span class="text-[10px] font-black uppercase tracking-widest opacity-40">Ikuti Kami</span>
                        <div class="flex items-center gap-6 text-[var(--color-text-primary)]/70">
                            @if($settings->x_url)
                            <a href="{{ $settings->x_url }}" class="hover:text-[var(--color-accent-primary)]">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            @endif
                            @if($settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}" class="hover:text-[var(--color-accent-primary)]">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03.284-2 1.5-2h1.5V1.75c-.273-.037-1.215-.125-2.307-.125C12.42 1.625 10 3.12 10 6.5v3H7v4h3V22h4v-8.5z"/></svg>
                            </a>
                            @endif
                            @if($settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}" class="hover:text-[var(--color-accent-primary)]">
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.981 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-12">
            @yield('content')
        </main>

        {{-- FOOTER (Editorial Magazine Style) --}}
        <footer class="mt-16 border-t-8 border-[var(--color-text-primary)] bg-[var(--color-bg-secondary)] pb-12 pt-16 lg:pt-24">
            <div class="mx-auto w-full max-w-7xl px-6">
                
                {{-- Top Section: Logo & Grid --}}
                <div class="grid gap-12 lg:grid-cols-[1.5fr_2fr]">
                    
                    {{-- Left: Identity --}}
                    <div class="flex flex-col border-b-2 border-[var(--color-border)] pb-10 lg:border-b-0 lg:border-r-2 lg:pb-0 lg:pr-12">
                        <a href="{{ route('blog.home') }}" class="group inline-block no-underline">
                            @if($logoLarge = $settings->logo_large_url)
                                <img src="{{ $logoLarge }}" alt="{{ $settings->site_name }}" 
                                     class="h-24 w-auto transition-transform duration-500 group-hover:scale-105"
                                     :class="{ 'brightness-0 invert': dark }">
                            @else
                                <span class="text-5xl font-black italic tracking-tighter text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-accent-primary)]">
                                    {{ Str::lower($settings->site_name) }}<span class="text-[var(--color-accent-secondary)]">.id</span>
                                </span>
                            @endif
                        </a>
                        <p class="mt-8 text-sm font-medium leading-relaxed text-[var(--color-text-secondary)] opacity-90 xl:text-[15px]">
                            {{ $settings->site_description }}
                        </p>
                        
                        <div class="mt-10 mb-2 font-black uppercase tracking-widest text-[10px] text-[var(--color-text-secondary)]">
                            Jaringan Media
                        </div>
                        <div class="flex items-center gap-5">
                            @if($settings->x_url)
                                <a href="{{ $settings->x_url }}" target="_blank" rel="noopener noreferrer" aria-label="X (Twitter)"
                                   class="text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                            @endif
                            @if($settings->facebook_url)
                                <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                                   class="text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03.284-2 1.5-2h1.5V1.75c-.273-.037-1.215-.125-2.307-.125C12.42 1.625 10 3.12 10 6.5v3H7v4h3V22h4v-8.5z"/></svg>
                                </a>
                            @endif
                            @if($settings->instagram_url)
                                <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                                   class="text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                    <svg class="h-5 w-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.981 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zM12 16a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Right: Link Grid --}}
                    <div class="grid gap-8 sm:grid-cols-3 sm:gap-6 lg:pl-4">
                        {{-- Topik --}}
                        <div>
                            <h3 class="mb-5 border-l-4 border-[var(--color-text-primary)] pl-3 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)]">
                                Topik Utama
                            </h3>
                            <ul class="space-y-3">
                                @foreach(($categories ?? collect())->whereNull('parent_id') as $navCategory)
                                    <li>
                                        <a href="{{ route('blog.category', $navCategory->slug) }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                            {{ $navCategory->name }}
                                            <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Perusahaan --}}
                        <div>
                            <h3 class="mb-5 border-l-4 border-[var(--color-text-primary)] pl-3 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)]">
                                Informasi
                            </h3>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('page.about') }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                        Tentang Kami
                                        <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('page.contact') }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                        Redaksi & Kontak
                                        <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('page.disclaimer') }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                        Penyangkalan
                                        <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>

                        {{-- Legalitas --}}
                        <div>
                            <h3 class="mb-5 border-l-4 border-[var(--color-text-primary)] pl-3 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)]">
                                Kebijakan
                            </h3>
                            <ul class="space-y-3">
                                <li>
                                    <a href="{{ route('page.privacy') }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                        Privasi
                                        <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('page.tos') }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                        Syarat & Ketentuan
                                        <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('page.pedoman-media-siber') }}" class="group flex w-full items-center justify-between border-b border-[var(--color-border)] pb-2 text-[13px] font-bold text-[var(--color-text-primary)] transition-colors hover:text-[var(--color-accent-primary)]">
                                        Pedoman Media Siber
                                        <span class="text-[var(--color-text-secondary)] opacity-0 transition-opacity group-hover:opacity-100">&rarr;</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Bottom Copyright Section --}}
                <div class="mt-16 flex flex-col items-center justify-between gap-4 border-t-4 border-[var(--color-text-primary)] pt-6 md:flex-row">
                    <p class="text-[11px] font-bold uppercase tracking-widest text-[var(--color-text-primary)]">
                        &copy; {{ now()->year }} {{ $settings->site_name }}. HAK CIPTA DILINDUNGI.
                    </p>
                    <div class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-text-secondary)]">
                        <span>Edisi {{ now()->translatedFormat('F Y') }}</span>
                    </div>
                </div>

            </div>
        </footer>

    </div>


</body>
</html>
