@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'bg-accent-primary p-1.5',
    'dropdownClasses' => ''
])

@php
switch ($align) {
    case 'left':
        $alignmentClasses = 'origin-top-left left-0';
        break;
    case 'top':
        $alignmentClasses = 'origin-top';
        break;
    case 'none':
    case 'false':
        $alignmentClasses = '';
        break;
    case 'right':
    default:
        $alignmentClasses = 'origin-top-right right-0';
        break;
}

switch ($width) {
    case '48':
        $widthClasses = 'w-48';
        break;
    case 'full':
        $widthClasses = 'w-full';
        break;
    default:
        $widthClasses = $width;
        break;
}
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    {{-- Trigger --}}
    <div @click="open = ! open" class="cursor-pointer">
        {{ $trigger }}
    </div>

    {{-- Dropdown Content --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
         class="absolute z-50 {{ $alignmentClasses }} {{ $widthClasses }} {{ $dropdownClasses }} top-11 rounded-lg border border-border shadow-2xl shadow-black/20"
         style="display: none;"
    >
        <div class="rounded-lg {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
