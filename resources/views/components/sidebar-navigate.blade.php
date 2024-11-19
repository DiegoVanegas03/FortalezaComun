@props(['items' => []]) <!-- Propiedad para pasar los elementos del menú -->

<div x-data="{ open: false }" class="flex relative">
    {{-- Parte Cerrada del side bar --}}
    <div class="bg-white z-50 flex flex-col gap-5">
        <!-- Botón de hamburguesa -->
        <button @click="open = ! open" class="focus:outline-none flex items-center justify-center my-5">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
            </svg>
        </button>
        <hr>
        <div class="flex items-center flex-1 flex-col gap-5">
            @foreach ($items as $item)
            <a href="{{route($item['route']) }}" class="hover:opacity-50 {{ request()->routeIs($item['route']) ? 'text-yellow-400' : '' }}">
                <i class="{{ $item['icon'] }}"></i>
            </a>            
            @endforeach
        </div>
        <hr>
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-dropdown-link class="text-danger" :href="route('logout')" onclick="event.preventDefault();
                                this.closest('form').submit();">
                <i class="fa-solid fa-right-from-bracket text-danger py-4 text-lg"></i>
            </x-dropdown-link>
        </form>
    </div>
    <!-- Overlay para oscurecer el fondo -->
    <div x-show="open" @click="open = false" class="fixed inset-0 bg-black bg-opacity-50 z-40 transition-opacity duration-300" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

    <!-- Sidebar -->
    <div x-show="open" class="bg-white w-64 h-screen shadow-lg flex justify-center fixed inset-y-0 left-0 z-50 transition-transform duration-300 ease-in-out" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform -translate-x-full" x-transition:enter-end="transform translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="transform translate-x-0" x-transition:leave-end="transform -translate-x-full">
        <div class="flex flex-col mt-4 w-full">
            <a href="{{ route('home') }}" class="py-4 flex flex-col items-center justify-center gap-4">
                <img class="rounded-full" src="{{ asset('storage/images/Logo-Fortaleza-Comun.jpeg') }}" width="90px"/>
                <p>Regresar a home</p>
            </a>
            <hr>
            <div class="flex-1 py-5 px-2">
                @foreach ($items as $item)
                    @if ($item['route'] !== 'home')
                        <a href="{{ route($item['route']) }}" class="flex items-center p-2 hover:opacity-50 {{ request()->routeIs($item['route']) ? 'text-yellow-400' : '' }}">
                            <i class="{{$item['icon']}}"></i>
                            <span class="ml-4">{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </div>
            <hr>
            <p class="text-center">Ususario : {{Auth::user()->name}}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-dropdown-link class="text-danger flex gap-2 items-center justify-center" :href="route('logout')" onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    <i class="fa-solid fa-right-from-bracket text-danger text-lg"></i> Cerrar Session 
                </x-dropdown-link>
            </form>
        </div>
    </div>

    <!-- Contenido principal sin desplazamiento -->
    <div class="flex-grow transition-all duration-300 min-h-screen">
        {{ $slot }} <!-- Aquí se mostrará el contenido principal -->
    </div>
</div>


