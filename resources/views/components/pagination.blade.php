@props([
    'paginator',
    'perPageOptions' => [5, 10, 15, 20],
])

@php
    $currentPage = $paginator->currentPage();
    $lastPage    = $paginator->lastPage();
    $total       = $paginator->total();
    $perPage     = $paginator->perPage();
    $prevUrl     = $paginator->previousPageUrl();
    $nextUrl     = $paginator->nextPageUrl();

    $pageUrls = [];
    for ($i = 1; $i <= $lastPage; $i++) {
        $pageUrls[$i] = $paginator->url($i);
    }

    $perPageUrls = [];
    foreach ($perPageOptions as $opt) {
        $perPageUrls[$opt] = $paginator->url(1) . (str_contains($paginator->url(1), '?') ? '&' : '?') . 'per_page=' . $opt;
    }

    $uid = 'pag_' . uniqid();
@endphp

@if($paginator->hasPages() || $total > min($perPageOptions))
<div class="mt-10 border-t border-border pt-6">
    <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-text-secondary">

        {{-- LEFT: Tampilkan --}}
        <div class="flex items-center gap-2">
            <span class="text-[13px]">Tampilkan</span>

            {{-- Per-page custom dropdown --}}
            <div class="relative" id="{{ $uid }}_pp_wrap">
                <button type="button"
                        onclick="toggleDropdown('{{ $uid }}_pp')"
                        class="flex min-w-[60px] cursor-pointer items-center justify-between gap-2 rounded-md border border-border bg-bg-primary px-3 py-1.5 text-[13px] font-semibold text-text-primary transition-colors hover:border-accent-secondary">
                    <span id="{{ $uid }}_pp_label">{{ $perPage }}</span>
                    <svg class="h-3.5 w-3.5 text-text-secondary/50 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div id="{{ $uid }}_pp"
                     class="absolute left-0 top-full z-50 mt-1 hidden w-[160px] rounded-lg border border-border bg-bg-primary shadow-lg">
                    {{-- Search --}}
                    <div class="border-b border-border p-2">
                        <div class="flex items-center gap-2 rounded-md border border-border px-2.5 py-1.5">
                            <svg class="h-3.5 w-3.5 shrink-0 text-text-secondary/40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <label for="{{ $uid }}_pp_search" class="sr-only">Cari opsi tampilkan</label>
                            <input id="{{ $uid }}_pp_search" type="text"
                                   placeholder="Cari tampilkan..."
                                   oninput="filterDropdown(this, '{{ $uid }}_pp_list')"
                                   class="w-full bg-transparent text-[12px] text-text-primary outline-none placeholder:text-text-secondary/40">
                        </div>
                    </div>
                    {{-- Options --}}
                    <ul id="{{ $uid }}_pp_list" class="max-h-[180px] overflow-y-auto py-1">
                        @foreach($perPageUrls as $opt => $url)
                            <li data-label="{{ $opt }}">
                                <a href="{{ $url }}"
                                   class="flex items-center gap-2 px-3 py-2 text-[13px] no-underline transition-colors hover:bg-accent-secondary/10 hover:text-accent-primary {{ $opt == $perPage ? 'bg-bg-secondary/40 font-bold text-accent-primary' : 'text-text-secondary' }}">
                                    @if($opt == $perPage)
                                        <svg class="h-3 w-3 shrink-0 text-accent-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <span class="h-3 w-3 shrink-0"></span>
                                    @endif
                                    {{ $opt }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <span class="text-[13px]">Item</span>
            <span class="hidden h-4 w-px bg-border sm:inline-block"></span>
            <span class="hidden text-[13px] sm:inline">
                dari total <strong class="text-text-primary">{{ number_format($total) }}</strong>
            </span>
        </div>

        {{-- RIGHT: Halaman + prev/next --}}
        @if($paginator->hasPages())
        <div class="flex items-center gap-2">
            <span class="text-[13px]">Halaman</span>

            {{-- Page custom dropdown --}}
            <div class="relative" id="{{ $uid }}_pg_wrap">
                <button type="button"
                        onclick="toggleDropdown('{{ $uid }}_pg')"
                        class="flex min-w-[60px] cursor-pointer items-center justify-between gap-2 rounded-md border border-accent-secondary bg-bg-primary px-3 py-1.5 text-[13px] font-bold text-text-primary transition-colors hover:border-accent-secondary">
                    <span id="{{ $uid }}_pg_label">{{ $currentPage }}</span>
                    <svg class="h-3.5 w-3.5 text-text-secondary/50" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <div id="{{ $uid }}_pg"
                     class="absolute bottom-full left-0 z-50 mb-1 hidden w-[180px] rounded-lg border border-border bg-bg-primary shadow-lg">
                    {{-- Search --}}
                    <div class="border-b border-border p-2">
                        <div class="flex items-center gap-2 rounded-md border border-border px-2.5 py-1.5">
                            <svg class="h-3.5 w-3.5 shrink-0 text-text-secondary/40" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                            <label for="{{ $uid }}_pg_search" class="sr-only">Cari halaman</label>
                            <input id="{{ $uid }}_pg_search" type="text"
                                   placeholder="Cari halaman..."
                                   oninput="filterDropdown(this, '{{ $uid }}_pg_list')"
                                   class="w-full bg-transparent text-[12px] text-text-primary outline-none placeholder:text-text-secondary/40">
                        </div>
                    </div>
                    {{-- Options --}}
                    <ul id="{{ $uid }}_pg_list" class="max-h-[200px] overflow-y-auto py-1">
                        @foreach($pageUrls as $page => $url)
                            <li data-label="{{ $page }}">
                                <a href="{{ $url }}"
                                   class="flex items-center gap-2 px-3 py-2 text-[13px] no-underline transition-colors hover:bg-accent-secondary/10 hover:text-accent-primary {{ $page == $currentPage ? 'bg-bg-secondary/40 font-bold text-accent-primary' : 'text-text-secondary' }}">
                                    @if($page == $currentPage)
                                        <svg class="h-3 w-3 shrink-0 text-accent-secondary" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                                        </svg>
                                    @else
                                        <span class="h-3 w-3 shrink-0"></span>
                                    @endif
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <span class="text-[13px]">
                dari <strong class="text-text-primary">{{ $lastPage }}</strong>
            </span>

            <div class="ml-1 flex items-center gap-1">
                {{-- Prev --}}
                @if($prevUrl)
                    <a href="{{ $prevUrl }}"
                       class="flex h-8 w-8 items-center justify-center rounded-md border border-border text-text-secondary no-underline transition-all hover:border-accent-primary hover:bg-accent-primary hover:text-bg-primary"
                       aria-label="Sebelumnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                @else
                    <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-md border border-border/40 text-text-secondary/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </span>
                @endif

                {{-- Next --}}
                @if($nextUrl)
                    <a href="{{ $nextUrl }}"
                       class="flex h-8 w-8 items-center justify-center rounded-md border border-border text-text-secondary no-underline transition-all hover:border-accent-primary hover:bg-accent-primary hover:text-bg-primary"
                       aria-label="Berikutnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @else
                    <span class="flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-md border border-border/40 text-text-secondary/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>
@endif

<script>
    function toggleDropdown(id) {
        const el = document.getElementById(id);
        const isHidden = el.classList.contains('hidden');

        // Close all open dropdowns first
        document.querySelectorAll('[id$="_pp"],[id$="_pg"]').forEach(d => {
            if (!d.id.endsWith('_list') && !d.id.endsWith('_label') && !d.id.endsWith('_wrap')) {
                d.classList.add('hidden');
            }
        });

        if (isHidden) {
            el.classList.remove('hidden');
            // Focus search
            const input = el.querySelector('input[type="text"]');
            if (input) setTimeout(() => input.focus(), 50);
        }
    }

    function filterDropdown(input, listId) {
        const query = input.value.toLowerCase();
        const items = document.getElementById(listId)?.querySelectorAll('li');
        if (!items) return;
        items.forEach(li => {
            const label = li.dataset.label?.toLowerCase() ?? '';
            li.style.display = label.includes(query) ? '' : 'none';
        });
    }

    // Close on outside click
    document.addEventListener('click', function(e) {
        document.querySelectorAll('[id$="_pp"],[id$="_pg"]').forEach(d => {
            if (!d.id.endsWith('_list') && !d.id.endsWith('_label') && !d.id.endsWith('_wrap')) {
                const wrap = document.getElementById(d.id + '_wrap');
                if (wrap && !wrap.contains(e.target)) {
                    d.classList.add('hidden');
                }
            }
        });
    });
</script>
