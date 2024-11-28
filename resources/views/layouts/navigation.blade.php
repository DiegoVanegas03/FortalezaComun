<nav x-data="{ open: false }" class="bg-app-secondary z-50 fixed w-screen">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex">
                <!-- Logo -->
                <div class="flex flex-shrink-0 items-center">
                    <a href="{{ route('home') }}">
                        <img class="rounded-full" src="{{ asset('storage/images/Logo-Fortaleza-Comun.jpeg') }}" width="60px" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 lg:-my-px lg:ml-10 lg:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('INICIO') }}
                    </x-nav-link>
                    <x-nav-link :href="route('proposito')" :active="request()->routeIs('proposito')">
                        {{ __('PROPÓSITO') }}
                    </x-nav-link>
                    <x-nav-link :href="route('reseñas')" :active="request()->routeIs('reseñas')">
                        {{ __('RESEÑAS') }}
                    </x-nav-link>
                    <x-nav-link :href="route('soporte')" :active="request()->routeIs('soporte')">
                        {{ __('SOPORTE') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden lg:flex lg:items-center lg:ml-6">
                @auth
                <x-dropdown align="left">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center text-sm font-medium text-white transition duration-150 ease-in-out hover:opacity-50 hover:border-gray-300 focus:outline-none">
                            <div class="uppercase">{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('users.index')">
                            {{ __('Panel de administracion') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi cuenta') }}
                        </x-dropdown-link>
                        <hr>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link class="text-danger" :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <a href="{{ route('login') }}" class="text-lg uppercase font-semibold text-black/80 tracking-wide rounded-xl py-1 px-6 bg-yellow-400 shadow-lg">Iniciar sesión</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 lg:hidden">
                <button @click="open = ! open"
                    class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden">
        <!-- Responsive Settings Options -->
        <div class="flex gap-3 flex-col border-t border-gray-200 pt-4">
            <div>
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                    {{ __('INICIO') }}
                </x-nav-link>
            </div>
            <div>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('FORMULARIO') }}
                </x-nav-link>
            </div>
            <div>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('PERFIL') }}
                </x-nav-link>
            </div>
            <div>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('RESEÑAS') }}
                </x-nav-link>
            </div>
            <div>
                <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('REPORTE') }}
                </x-nav-link>
            </div>
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
            @else
            <div class="gap-2 py-3 flex flex-col">
                <a href="{{ route('login') }}" class="text-lg whitespace-nowrap uppercase xl:tracking-wide text-center text-white">Iniciar sesión</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="ml-4 text-lg uppercase font-semibold text-black/80 tracking-wide rounded-xl py-1 px-6 bg-yellow-400">Registro</a>
                @endif
            </div>
            @endauth
        </div>
    </div>
</nav>