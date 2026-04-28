@props(['links' => []])

@php
    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => route('blog.home')
            ]
        ]
    ];
    $position = 2;
    foreach($links as $link) {
        $item = [
            '@type' => 'ListItem',
            'position' => $position,
            'name' => $link['label']
        ];
        if (isset($link['url'])) {
            $item['item'] = $link['url'];
        }
        $jsonLd['itemListElement'][] = $item;
        $position++;
    }
@endphp
<script type="application/ld+json">
{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>

<nav class="mb-7 flex text-xs text-text-secondary/60" aria-label="Breadcrumb">
    <ol class="flex flex-wrap items-center gap-1">
        <li class="flex items-center">
            <a href="{{ route('blog.home') }}"
               class="font-medium text-text-secondary/60 no-underline transition-colors hover:text-accent-primary">
                Home
            </a>
        </li>

        @foreach($links as $link)
            <li class="flex items-center gap-1">
                <svg aria-hidden="true" class="h-3 w-3 shrink-0 text-border" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>

                @if(isset($link['url']))
                    <a href="{{ $link['url'] }}" class="font-medium text-text-secondary/60 no-underline transition-colors hover:text-accent-primary">
                        {{ $link['label'] }}
                    </a>
                @else
                    <span class="max-w-[200px] truncate font-semibold text-text-primary">
                        {{ $link['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
