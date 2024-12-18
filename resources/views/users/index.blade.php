<x-admin-layout>
    <div class="py-12 flex items-center justify-center w-full h-full max-h-screen">
        <div class="max-w-7xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-2 space-y-5">
                    <h1 class="text-4xl flex-1 uppercase text-center tracking-widest">Usuarios activos</h1>
                    <div class="flex gap-2 w-full px-5">
                        <a href="{{ route('users.import') }}" class="w-full">
                            <x-secondary-button class="w-full justify-center">
                                {{ __('Agregar usuarios desde un archivo excel.') }}
                            </x-secondary-button>
                        </a>
                        <a href="{{ route('users.add') }}" class="w-full">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Agregar un nuevo usuario.') }}
                            </x-primary-button>
                        </a>
                    </div>
                </div>
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div class="min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead>
                                <tr
                                    class=" bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-3">
                                        Nombre
                                    </th>
                                    <th class="px-6 py-3">
                                        Apellidos
                                    </th>
                                    <th class="px-6 py-3">
                                        Correo
                                    </th>
                                    <th class="px-6 py-3">
                                        Puesto
                                    </th>
                                    <th class="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach ($users as $user)
                                    <tr class="bg-white whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <td class="px-6 py-4 ">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $user->last_name }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $user->puesto }}
                                        </td>
                                        <td class="flex gap-4 items-center justify-center text-lg">
                                            <a href="{{ route('users.edit', $user->id) }}">
                                                <x-tooltip message="Editar usuario">
                                                    <i role="button"
                                                        class="fa-solid fa-pen-to-square hover:opacity-50 mr-4"></i>
                                                </x-tooltip>
                                            </a>
                                            <x-tooltip message="Eliminar" color="bg-danger">
                                                <i x-data=""
                                                    x-on:click.prevent="$dispatch('open-modal', { name: 'prestamo-deletion', id: '{{ $user->id }}' })"
                                                    role="button"
                                                    class="fa-solid fa-trash hover:opacity-50 text-red-500"></i>
                                            </x-tooltip>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <x-modal name="prestamo-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('users.destroy') }}" class="p-6">
            @csrf
            @method('delete')
            <input name="id" type="number" x-bind:value="formId" hidden />
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Estas seguro que quieres eliminar este prestamo?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Una vez que realices esta acción no se podra deshacer, escribe tu contraseña para autorizar la acción') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input id="password" name="password" type="password" class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}" />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ml-3">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    </x-app-layout>
