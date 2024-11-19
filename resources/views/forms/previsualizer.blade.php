<x-app-layout>
    <main class=" pt-[95px] grid place-items-center gap-5 h-screen" >
        <div class="bg-white rounded-xl shadow-xl">
            <div class="py-12 px-5 flex flex-col gap-5">
                <h1 class="text-2xl font-medium tracking-widest uppercase">{{ $form->name }}</h1>
                <p class="text-gray-600 uppercase text-sm italic ">{{ $form->description }}</p>
                
                @if($form->fields->isEmpty())
                    <p>No hay campos registrados en este formulario.</p>
                @else
                    <div class="space-y-4">
                        @foreach($form->fields as $field)
                            @if ($field->type !== "select")
                                <x-input-label :for="$field->label" :value="$field->label" />
                                <x-text-input :id="$field->label" class="block mt-1 w-full" :type="$field->type" :name="$field->label" :value="old($field->label,'')" :required="$field->required"/>
                                <x-input-error :messages="$errors->get($field->label)" class="mt-2" />
                            @else
                                <x-input-label :for="$field->label" :value="$field->label" />
                                <x-select-input :id="$field->label" class="block mt-1 w-full" :options="explode(',', $field->options)" selected="" :name="$field->label" :requerido="$field->required"/>
                                <x-input-error :messages="$errors->get($field->label)" class="mt-2" />
                            @endif
 
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</x-app-layout>