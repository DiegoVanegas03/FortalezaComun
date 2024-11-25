@php
    $options = [['value' => 'user', 'label' => 'User'], ['value' => 'user', 'label' => 'User']];
@endphp
<x-admin-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl flex-1 py-7">{{ $user ? 'Edicion de Usuario' : 'Creación de usuario' }}</h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form method="POST" action="{{ route($user ? 'users.update' : 'users.register') }}"
                    class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    @csrf
                    @if (!$user)
                        <x-slot name="header">
                            <h1 class="text-xl uppercase text-gray-900">
                                Libros nuevos
                            </h1>
                        </x-slot>
                    @else
                        @method('patch')
                        <input name="id" hidden value="{{ $user->id }}" />
                        <x-slot name="header">
                            <h1 class="text-xl uppercase text-gray-900">
                                Edicion de libros
                            </h1>
                        </x-slot>
                    @endif
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Nombre -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name', $user->name ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Correo -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                                :value="old('email', $user->email ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <!-- Puesto -->
                        <div>
                            <x-input-label for="puesto" :value="__('Puesto')" />
                            <x-text-input id="puesto" class="block mt-1 w-full" type="text" name="puesto"
                                :value="old('puesto', $user->puesto ?? '')" required autofocus />
                            <x-input-error :messages="$errors->get('puesto')" class="mt-2" />
                        </div>
                        @if (!$user)
                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                                    :value="old('password', '')" required autofocus />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                        @endif
                    </div>
                    <div class="flex md:flex-row gap-4 mt-4">
                        <a href="{{ route('users.index') }}" class="w-full">
                            <x-secondary-button class="w-full justify-center">
                                Cancelar
                            </x-secondary-button>
                        </a>
                        <x-primary-button class="w-full justify-center">
                            Guardar Ususario
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </x-app-layout>
