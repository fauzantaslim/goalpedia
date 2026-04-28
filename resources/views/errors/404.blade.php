@extends('layouts.app')

@section('content')
<div class="relative flex min-h-[80vh] flex-col items-center justify-center overflow-hidden">

    {{-- Grid lines background (stadium / pitch lines) --}}
    <div class="pointer-events-none absolute inset-0 opacity-[0.04]" aria-hidden="true">
        <div class="absolute left-1/2 top-0 h-full w-px -translate-x-1/2 bg-[var(--color-text-primary)]"></div>
        <div class="absolute left-0 top-1/2 h-px w-full -translate-y-1/2 bg-[var(--color-text-primary)]"></div>
        <div class="absolute left-1/2 top-1/2 h-48 w-48 -translate-x-1/2 -translate-y-1/2 rounded-full border border-[var(--color-text-primary)]"></div>
    </div>

    {{-- Massive offside code --}}
    <div class="pointer-events-none absolute inset-0 flex items-center justify-center select-none" aria-hidden="true">
        <span class="text-[200px] font-black leading-none tracking-tighter text-[var(--color-text-primary)] opacity-[0.04] md:text-[300px] lg:text-[400px]">404</span>
    </div>

    {{-- Main panel: referee card style --}}
    <div class="group relative z-10 w-full max-w-2xl border-y-8 border-[var(--color-text-primary)] bg-[var(--color-bg-primary)] px-8 py-14 text-center shadow-2xl transition-all duration-500 md:px-16 md:py-20">

        {{-- Red card badge --}}
        <div class="absolute -top-6 left-1/2 -translate-x-1/2">
            <div class="flex h-12 w-8 items-center justify-center bg-[var(--color-accent-secondary)] shadow-lg shadow-[var(--color-accent-secondary)]/40 transition-transform duration-300 group-hover:rotate-12">
                <span class="sr-only">Red Card</span>
            </div>
        </div>

        <div class="mb-8 flex items-center justify-center gap-5">
            <span class="h-px flex-1 bg-[var(--color-accent-secondary)]"></span>
            <p class="text-[11px] font-black uppercase tracking-[0.35em] text-[var(--color-accent-secondary)]">Off-Side!</p>
            <span class="h-px flex-1 bg-[var(--color-accent-secondary)]"></span>
        </div>

        <h1 class="mb-2 text-6xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] sm:text-8xl">
            Halaman<br>Hilang
        </h1>

        <p class="mx-auto mt-6 max-w-sm text-sm font-medium leading-relaxed tracking-wide text-[var(--color-text-secondary)] opacity-80">
            Wasit telah meniup peluit. Halaman atau artikel yang Anda cari tidak ditemukan di lapangan kami — mungkin sudah dipindah ke bangku cadangan.
        </p>

        {{-- Actions --}}
        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('blog.home') }}"
               class="group/btn relative inline-flex h-14 items-center justify-center overflow-hidden border-2 border-[var(--color-text-primary)] bg-[var(--color-text-primary)] px-10 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-bg-primary)] transition-colors">
                <span class="absolute inset-0 -translate-x-full bg-[var(--color-accent-secondary)] transition-transform duration-300 group-hover/btn:translate-x-0"></span>
                <span class="relative z-10 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-300 group-hover/btn:-translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Lapangan
                </span>
            </a>
            <button @click="searchOpen = true"
                    class="group/btn relative inline-flex h-14 items-center justify-center overflow-hidden border-2 border-[var(--color-text-primary)] bg-transparent px-10 text-xs font-black uppercase tracking-[0.2em] text-[var(--color-text-primary)] transition-colors hover:bg-[var(--color-text-primary)] hover:text-[var(--color-bg-primary)]">
                Cari Artikel
            </button>
        </div>

    </div>

</div>
@endsection
