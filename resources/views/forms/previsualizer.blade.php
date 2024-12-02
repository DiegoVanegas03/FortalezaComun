<x-app-layout>
    <main class=" pt-[95px] grid place-items-center gap-5 h-screen">
        <div class="bg-white rounded-xl shadow-xl max-w-4xl relative">
            <p class="absolute top-0 left-0 p-4 text-xl flex items-center gap-2 hover:opacity-50" role="button"
                onclick="window.location.href='{{ url()->previous() }}'">
                <i class="fa-solid fa-arrow-left"></i>
                <span class="text-xs italic">Volver</span>
            </p>
            <div class="py-12 px-5 flex flex-col gap-5">
                <h1 class="text-2xl text-center font-medium tracking-widest uppercase">{{ $form->name }}</h1>
                <p class="text-gray-600 uppercase text-sm italic ">{{ $form->description }}</p>

                @if ($form->fields->isEmpty())
                    <p>No hay campos registrados en este formulario.</p>
                @else
                    <form method="POST" action="{{ $permitedAction ? route('forms.response') : '' }}" class="space-y-4">
                        @csrf
                        @if ($permitedAction)
                            <input name="id" value="{{ $form->id }}" hidden>
                        @endif
                        @foreach ($form->fields as $field)
                            @if ($field->type !== 'select')
                                <x-input-label :for="$field->label" :value="$field->label" />
                                <x-text-input :id="$field->label" class="block mt-1 w-full" :type="$field->type"
                                    :name="$field->label" :value="old($field->label, '')" :required="$field->required" />
                                <x-input-error :messages="$errors->get($field->label)" class="mt-2" />
                            @else
                                <x-input-label :for="$field->label" :value="$field->label" />
                                <x-select-input :id="$field->label" class="block mt-1 w-full" :options="explode(',', $field->options)"
                                    selected="" :name="$field->label" :requerido="$field->required" />
                                <x-input-error :messages="$errors->get($field->label)" class="mt-2" />
                            @endif
                        @endforeach
                        <x-primary-button class="justify-center h-10 w-full">Enviar respuesta</x-primary-button>
                    </form>
                @endif
                <p class="text-xs text-gray-400">
                    La información proporcionada será utilizada exclusivamente para el análisis y la mejora continua del
                    área de trabajo. Al enviar los datos, otorgas tu consentimiento para su uso conforme a nuestras
                    políticas.
                </p>

            </div>
        </div>
    </main>
</x-app-layout>
