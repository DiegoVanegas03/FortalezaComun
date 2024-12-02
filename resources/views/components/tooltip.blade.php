@props(['color', 'message'])
<div x-data="{ open: false }" class="relative">
    <!-- Elemento activador -->
    <span @mouseenter="open = true" @mouseleave="open = false" class="cursor-pointer ">
        {{ $slot }}
    </span>

    <!-- Contenido del tooltip -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
        class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 {{ $color ?? 'bg-gray-800' }} text-white text-sm rounded px-3 py-2 z-10 whitespace-nowrap shadow-lg pointer-events-none">
        {{ $message }}
    </div>
</div>
