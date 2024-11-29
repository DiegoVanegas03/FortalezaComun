<x-admin-layout>
    <div class="py-12 flex items-center justify-center w-full h-full max-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex py-2">
                <h1 class="text-2xl flex-1 uppercase tracking-widest">Formularios creados</h1>
                <a href="{{ route('forms.add') }}">
                    <x-secondary-button>
                        {{ __('Agregar un nuevo formulario.') }}
                    </x-secondary-button>
                </a>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
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
                                        Descripcion
                                    </th>
                                    <th class="px-6 py-3">
                                        Número de preguntas
                                    </th>
                                    <th class="px-6 py-3">
                                        Número de respuestas
                                    </th>
                                    <th class="px-6 py-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">
                                @foreach ($forms as $form)
                                    <tr class="bg-white whitespace-no-wrap text-sm leading-5 text-gray-900">
                                        <td class="px-6 py-4 ">
                                            {{ $form->name }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $form->description }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $form->fieldsCount() }}
                                        </td>
                                        <td class="px-6 py-4 ">
                                            {{ $form->responsesCount() }}
                                        </td>
                                        <td class="text-center text-base">
                                            <a class="mr-4 hover:opacity-50"
                                                href="{{ route('forms.previsualizer', $form->id) }}">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>
                                            <a href="{{ route('forms.edit', $form->id) }}">
                                                <i role="button"
                                                    class="fa-solid fa-pen-to-square hover:opacity-50 mr-4"></i>
                                            </a>
                                            <i x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', { name: 'prestamo-deletion', id: '{{ $form->id }}' })"
                                                role="button"
                                                class="fa-solid fa-trash hover:opacity-50 text-red-500"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-2">
                        {{ $forms->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
    <x-modal name="prestamo-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('forms.delete') }}" class="p-6">
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
