@extends('layouts.app')

@section('content')

    <x-breadcrumbs :links="[
        ['label' => 'Kontak'],
    ]" />

    <article class="mx-auto w-full max-w-7xl">
        <div class="lg:grid lg:grid-cols-[1fr_1.25fr] lg:gap-16 xl:gap-24 lg:items-start pb-20">
            
            {{-- Left column: Typography & Details --}}
            <aside class="mb-16 lg:mb-0 lg:sticky lg:top-32">
                <div class="mb-5 flex items-center gap-4">
                    <div class="h-5 w-5 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                    <p class="text-[10px] font-black uppercase tracking-[0.35em] text-[var(--color-accent-secondary)]">Hubungi Redaksi</p>
                </div>
                
                <h1 class="mb-8 text-5xl font-black uppercase leading-[0.9] tracking-tighter text-[var(--color-text-primary)] md:text-7xl">
                    Kontak<br><span class="text-[var(--color-accent-primary)]">Kami.</span>
                </h1>
                
                <div class="space-y-5 border-l-4 border-[var(--color-accent-secondary)] pl-6 text-sm font-medium leading-relaxed text-[var(--color-text-secondary)] xl:text-base">
                    <p>
                        Punya cerita eksklusif dari balik lapangan? Anda melihat informasi transfer yang belum ramai dibicarakan? Tim redaksi Goalpedia siap mendengar.
                    </p>
                    <p>
                        Untuk kerjasama press release, sponsorship konten, atau pertanyaan editorial — kirim pesan Anda melalui formulir ini dan kami akan merespons dalam 1x24 jam.
                    </p>
                </div>

                {{-- Contact Info Cards --}}
                <div class="mt-10 space-y-0">
                    @foreach([
                        ['label' => 'Pengajuan Konten', 'desc' => 'Artikel tamu & opini sepak bola'],
                        ['label' => 'Press & Media', 'desc' => 'Rilis pers & kerjasama media'],
                        ['label' => 'Partnership', 'desc' => 'Sponsorship & afiliasi bisnis'],
                    ] as $info)
                        <div class="flex items-start gap-4 border-b border-[var(--color-border)] py-4 last:border-0">
                            <div class="mt-1 h-2 w-2 shrink-0 rotate-45 bg-[var(--color-accent-secondary)]"></div>
                            <div>
                                <p class="text-xs font-black uppercase tracking-widest text-[var(--color-text-primary)]">{{ $info['label'] }}</p>
                                <p class="mt-0.5 text-xs text-[var(--color-text-secondary)] opacity-70">{{ $info['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </aside>

            {{-- Right column: Contact Form Card --}}
            <section class="border-t-8 border-[var(--color-text-primary)] border-b-2 border-x-2 border-[var(--color-border)] bg-[var(--color-bg-primary)] p-8 sm:p-12 lg:p-16">
                
                @if(session('success'))
                    <div class="mb-8 rounded-lg bg-green-500/10 p-4 border border-green-500/20 text-center">
                        <p class="font-bold text-green-700">{{ session('success') }}</p>
                    </div>
                @endif
                
                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid gap-8 sm:grid-cols-2">
                        <div class="flex flex-col gap-2">
                            <label for="name" class="text-xs font-black uppercase tracking-widest text-[var(--color-text-primary)]">Nama Lengkap</label>
                            <input type="text" id="name" name="name" required placeholder="Cth: Satoshi Nakamoto" value="{{ old('name') }}"
                                   class="w-full border-b-2 border-[var(--color-bg-secondary)] bg-transparent py-3 text-lg font-semibold text-[var(--color-text-primary)] transition-colors placeholder:font-normal placeholder:opacity-30 focus:border-[var(--color-accent-primary)] focus:outline-none">
                            @error('name')<span class="text-xs text-red-500 font-bold">{{ $message }}</span>@enderror
                        </div>
                        <div class="flex flex-col gap-2">
                            <label for="email" class="text-xs font-black uppercase tracking-widest text-[var(--color-text-primary)]">Email Aktif</label>
                            <input type="email" id="email" name="email" required placeholder="cth: hello@domain.com" value="{{ old('email') }}"
                                   class="w-full border-b-2 border-[var(--color-bg-secondary)] bg-transparent py-3 text-lg font-semibold text-[var(--color-text-primary)] transition-colors placeholder:font-normal placeholder:opacity-30 focus:border-[var(--color-accent-primary)] focus:outline-none">
                            @error('email')<span class="text-xs text-red-500 font-bold">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="flex flex-col gap-2" x-data="{
                        selectedValue: '{{ old("subject") }}',
                        options: [
                            { value: 'partnership', label: 'Kerja Sama & Afiliasi Bisnis' },
                            { value: 'press', label: 'Agensi Rilis Berita (Press Release)' },
                            { value: 'contributor', label: 'Pengajuan Kontributor Opini' },
                            { value: 'general', label: 'Lainnya / Pelaporan Isu' }
                        ],
                        get selectedLabel() {
                            const found = this.options.find(opt => opt.value === this.selectedValue);
                            return found ? found.label : 'Pilih keperluan komunikasi...';
                        }
                    }">
                        <label for="subject" class="text-xs font-black uppercase tracking-widest text-[var(--color-text-primary)]">Tujuan / Subjek</label>
                        <input type="hidden" name="subject" id="subject" :value="selectedValue" required>
                        
                        <x-dropdown align="left" width="full" contentClasses="bg-[var(--color-bg-primary)] p-2">
                            <x-slot name="trigger">
                                <div class="flex w-full cursor-pointer items-center justify-between border-b-2 border-[var(--color-bg-secondary)] bg-transparent py-3 transition-colors hover:border-[var(--color-accent-primary)]">
                                    <span class="text-lg font-semibold text-[var(--color-text-primary)]" :class="{ 'opacity-30 font-normal': !selectedValue }" x-text="selectedLabel"></span>
                                    <svg class="h-5 w-5 text-[var(--color-text-primary)] opacity-50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </x-slot>

                            <x-slot name="content">
                                <ul class="flex flex-col gap-1">
                                    <template x-for="option in options" :key="option.value">
                                        <li>
                                            <button type="button"
                                                @click="selectedValue = option.value; open = false;"
                                                class="flex w-full items-center rounded-lg px-4 py-3 text-left text-sm font-semibold transition-colors"
                                                :class="selectedValue === option.value ? 'bg-[var(--color-accent-primary)] text-[var(--color-bg-primary)]' : 'text-[var(--color-text-primary)] hover:bg-[var(--color-bg-secondary)]'"
                                            >
                                                <span x-text="option.label"></span>
                                            </button>
                                        </li>
                                    </template>
                                </ul>
                            </x-slot>
                        </x-dropdown>
                        @error('subject')<span class="text-xs text-red-500 font-bold">{{ $message }}</span>@enderror
                    </div>

                    <div class="flex flex-col gap-2">
                        <label for="message" class="text-xs font-black uppercase tracking-widest text-[var(--color-text-primary)]">Pesan</label>
                        <textarea id="message" name="message" rows="4" required placeholder="Tuliskan pesan atau penawaran Anda selengkap mungkin..."
                                  class="w-full resize-none border-b-2 border-[var(--color-bg-secondary)] bg-transparent py-3 text-lg font-semibold text-[var(--color-text-primary)] transition-colors placeholder:font-normal placeholder:opacity-30 focus:border-[var(--color-accent-primary)] focus:outline-none">{{ old('message') }}</textarea>
                        @error('message')<span class="text-xs text-red-500 font-bold">{{ $message }}</span>@enderror
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                                class="group relative inline-flex w-full items-center justify-center border-2 border-[var(--color-text-primary)] bg-[var(--color-text-primary)] px-8 py-4 font-black uppercase tracking-widest text-[var(--color-bg-primary)] transition-colors hover:bg-transparent hover:text-[var(--color-text-primary)] sm:w-auto">
                            <span class="relative z-10">Kirim Pesan</span>
                        </button>
                    </div>
                </form>
            </section>
            
        </div>
    </article>

@endsection
