@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Tentang Kami'],
    ]" />

    <article class="mx-auto w-full max-w-7xl">

        {{-- ═══ HERO: Sport Magazine Masthead ══════════════════════════════ --}}
        <header class="relative mb-0 overflow-hidden border-b-8 border-[var(--color-text-primary)]">

            {{-- Background diagonal stripe (stadium energy) --}}
            <div class="absolute inset-0 pointer-events-none overflow-hidden">
                <div class="absolute -right-20 top-0 h-full w-1/3 -skew-x-6 bg-[var(--color-accent-primary)] opacity-5"></div>
                <div class="absolute -right-40 top-0 h-full w-1/4 -skew-x-6 bg-[var(--color-accent-secondary)] opacity-5"></div>
            </div>

            <div class="relative z-10 grid min-h-[60vh] grid-cols-1 items-end gap-0 lg:grid-cols-[1fr_auto]">

                {{-- Left: Masthead Text --}}
                <div class="px-2 pb-10 pt-12 md:pb-16">
                    <div class="mb-6 flex items-center gap-4">
                        <div class="h-6 w-6 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[var(--color-accent-secondary)]">Tentang Goalpedia</span>
                    </div>

                    <h1 class="text-6xl font-black uppercase leading-[0.85] tracking-tighter text-[var(--color-text-primary)] md:text-8xl lg:text-[100px] xl:text-[130px]">
                        Suara<br>
                        <span class="text-[var(--color-accent-primary)]">Sepak</span><br>
                        <span class="italic opacity-70">Bola.</span>
                    </h1>

                    <p class="mt-8 max-w-lg text-base font-medium leading-relaxed tracking-wide text-[var(--color-text-secondary)] md:text-lg">
                        Goalpedia hadir sebagai portal berita sepak bola yang menyajikan analisis mendalam, liputan pertandingan, statistik pemain, dan cerita di balik lapangan hijau — semua dalam satu platform.
                    </p>
                </div>

                {{-- Right: Big Number / Stat --}}
                <div class="hidden h-full items-center border-l-8 border-[var(--color-text-primary)] bg-[var(--color-text-primary)] px-12 py-10 lg:flex lg:flex-col lg:justify-end">
                    <div class="text-right">
                        <div class="text-8xl font-black text-[var(--color-bg-primary)] opacity-20 xl:text-[120px]">90<span class="text-5xl xl:text-7xl">'</span></div>
                        <p class="mt-2 text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-accent-secondary)]">Menit penuh semangat</p>
                    </div>
                </div>

            </div>
        </header>

        <!-- {{-- ═══ EDITORIAL SPREAD: Key Facts ══════════════════════════════ --}}
        <div class="grid grid-cols-2 border-b-4 border-[var(--color-text-primary)] md:grid-cols-4">
            @foreach([
                ['label' => 'Artikel Diterbitkan', 'value' => '500+', 'icon' => '📄'],
                ['label' => 'Liga Diliput', 'value' => '20+', 'icon' => '🏆'],
                ['label' => 'Kontributor', 'value' => '10', 'icon' => '✍️'],
                ['label' => 'Pembaca Bulanan', 'value' => '50K+', 'icon' => '👥'],
            ] as $i => $stat)
                <div class="group border-r border-[var(--color-border)] px-6 py-8 last:border-r-0 transition-colors hover:bg-[var(--color-text-primary)]">
                    <p class="mb-1 text-3xl font-black tracking-tighter text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-bg-primary)] md:text-5xl">{{ $stat['value'] }}</p>
                    <p class="text-[10px] font-black uppercase tracking-widest text-[var(--color-text-secondary)] transition-colors group-hover:text-[var(--color-bg-primary)]/60">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div> -->

        {{-- ═══ ABOUT COPY: Magazine Feature Story ═══════════════════════ --}}
        <section class="grid gap-0 border-b-8 border-[var(--color-text-primary)] md:grid-cols-[1fr_2px_1fr]">
            <div class="px-2 py-12 md:pr-12 md:py-16">
                <p class="mb-4 text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-accent-secondary)]">— Misi Kami</p>
                <h2 class="mb-6 text-4xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] md:text-5xl">
                    Lebih Dari<br>Sekadar<br><span class="text-[var(--color-accent-primary)]">Berita.</span>
                </h2>
                <p class="text-sm font-medium leading-[1.9] tracking-wide text-[var(--color-text-secondary)]">
                    Di Goalpedia, kami percaya bahwa sepak bola adalah lebih dari sekadar permainan. Ini adalah cerminan budaya, geopolitik, dan semangat manusia. Setiap laporan, analisis taktik, dan profil pemain yang kami hadirkan bertujuan untuk memperdalam apresiasi Anda terhadap olahraga paling populer di dunia.
                </p>
                <p class="mt-4 text-sm font-medium leading-[1.9] tracking-wide text-[var(--color-text-secondary)]">
                    Dari Liga Champions hingga kompetisi lokal Indonesia, tim redaksi kami memastikan Anda tidak pernah melewatkan momen-momen penting yang membentuk sejarah sepak bola.
                </p>
            </div>

            {{-- Divider --}}
            <div class="hidden w-px bg-[var(--color-text-primary)] md:block"></div>

            <div class="border-t-4 border-[var(--color-text-primary)] px-2 py-12 md:border-t-0 md:pl-12 md:py-16">
                <p class="mb-4 text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-accent-secondary)]">— Konten Unggulan</p>
                <ul class="space-y-0">
                    @foreach([
                        ['title' => 'Analisis Taktik', 'desc' => 'Bedah formasi dan strategi tim-tim besar dunia'],
                        ['title' => 'Berita Transfer', 'desc' => 'Update kabar panas bursa transfer pemain'],
                        ['title' => 'Profil Pemain', 'desc' => 'Kisah di balik bintang lapangan hijau'],
                        ['title' => 'Match Report', 'desc' => 'Laporan pertandingan penuh mendalam dan berimbang'],
                        ['title' => 'Data & Statistik', 'desc' => 'Angka-angka yang menceritakan sepak bola'],
                    ] as $item)
                        <li class="group flex items-start gap-4 border-b border-[var(--color-border)] py-5 last:border-0 transition-colors hover:bg-[var(--color-text-primary)]/5">
                            <span class="mt-1 shrink-0 h-2 w-2 bg-[var(--color-accent-secondary)] transition-transform group-hover:scale-150"></span>
                            <div>
                                <p class="font-black uppercase tracking-widest text-[var(--color-text-primary)] text-sm">{{ $item['title'] }}</p>
                                <p class="mt-0.5 text-xs text-[var(--color-text-secondary)] opacity-70">{{ $item['desc'] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        {{-- ═══ CORE VALUES: Sport Pillars ═══════════════════════════════ --}}
        <section class="py-16 lg:py-24">
            <div class="mb-12 flex items-end justify-between border-b-4 border-[var(--color-text-primary)] pb-4">
                <h2 class="text-5xl font-black uppercase leading-none tracking-tighter text-[var(--color-text-primary)] md:text-7xl">
                    Kode<br><span class="text-[var(--color-accent-secondary)]">Kami.</span>
                </h2>
                <span class="hidden text-[10px] font-black uppercase tracking-[0.3em] text-[var(--color-text-secondary)] opacity-50 md:block">4 Prinsip Redaksi</span>
            </div>

            <div class="grid gap-px bg-[var(--color-text-primary)] border border-[var(--color-text-primary)] sm:grid-cols-2 lg:grid-cols-4">
                @foreach([
                    ['num' => 'I', 'title' => 'Akurat', 'desc' => 'Setiap fakta diverifikasi sebelum dipublikasikan. Tidak ada rumor, hanya kebenaran di lapangan.'],
                    ['num' => 'II', 'title' => 'Cepat', 'desc' => 'Breaking news seputar sepak bola dunia dan lokal disajikan real-time tanpa mengorbankan akurasi.'],
                    ['num' => 'III', 'title' => 'Mendalam', 'desc' => 'Lebih dari sekadar skor: kami bedah konteks, taktik, dan cerita di balik setiap pertandingan.'],
                    ['num' => 'IV', 'title' => 'Netral', 'desc' => 'Fans semua klub disambut. Perspektif kami tidak berpihak pada tim mana pun di luar lapangan.'],
                ] as $v)
                    <div class="group flex flex-col bg-[var(--color-bg-primary)] p-8 transition-colors duration-300 hover:bg-[var(--color-text-primary)]">
                        <div class="mb-6 text-7xl font-black leading-none text-[var(--color-text-primary)] opacity-10 transition-all duration-300 group-hover:text-[var(--color-accent-secondary)] group-hover:opacity-100">{{ $v['num'] }}</div>
                        <h3 class="mb-3 text-2xl font-black uppercase tracking-widest text-[var(--color-text-primary)] transition-colors group-hover:text-[var(--color-bg-primary)]">{{ $v['title'] }}</h3>
                        <p class="text-sm font-medium leading-relaxed text-[var(--color-text-secondary)] transition-colors group-hover:text-[var(--color-bg-primary)]/70">{{ $v['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

    </article>

@endsection
