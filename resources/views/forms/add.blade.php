<x-admin-layout>
    <div class="py-12 flex items-center justify-center w-full h-full max-h-screen">
        <div class="max-w-7xl mx-auto p-6 drop-shadow-xl bg-white rounded-lg">
            <h1 class="text-2xl uppercase font-medium tracking-widest mb-6">Crear Formulario Personalizado</h1>
            <!-- Formulario para crear un nuevo formulario -->
            <form id="form-create" action="{{ route('forms.register') }}" method="POST">
                @csrf
                <!-- Nombre del formulario -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nombre del Formulario')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $form->name ?? '')"
                        required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Descripción del formulario -->
                <div class="mb-4">
                    <x-input-label for="description" :value="__('Descripcion')" />
                    <textarea id="description" name="description" class="w-full border rounded p-2" rows="3"
                        placeholder="Descripción opcional">{{ old('description', $form->description ?? '') }}</textarea>
                </div>

                <!-- Sección para añadir campos al formulario -->
                <div class="mb-4 border-b-2 border-b-black">
                    <h2 class="text-lg uppercase tracking-widest mb-4">Campos del Formulario</h2>

                    <!-- Botón para agregar un nuevo campo -->
                    <div class="flex justify-end mb-4">
                        <x-secondary-button type="button" id="add-field">Agregar Campo</x-secondary-button>
                    </div>

                    <div id="fields-container" class="overflow-y-auto max-h-80">
                        <!-- Aquí se insertarán dinámicamente los campos del formulario -->
                    </div>
                </div>
                <!-- Botón para enviar el formulario -->
                <x-primary-button type="submit" class="w-full justify-center">Guardar Formulario</x-primary-button>
            </form>
        </div>

    </div>
    <!-- Plantilla para un campo (oculta) -->
    <template id="field-template">
        <div class="field mb-4 border-t border-t-black pt-4">
            <div class="flex justify-between gap-2">
                <!-- Etiqueta del campo -->
                <div class="mb-2 w-full">
                    <x-input-label :value="__('Etiqueta del Campo:')" />
                    <x-text-input class="block mt-1 w-full" type="text" name="fields[__INDEX__][label]" required />
                </div>

                <!-- Tipo de campo -->
                <div>
                    <x-input-label class=" whitespace-nowrap" :value="__('Tipo de Campo')" />
                    <select class="w-full mt-1 block field-type" name="fields[__INDEX__][type]" required>
                        <option value="text">Texto</option>
                        <option value="select">Seleccionar</option>
                        <option value="number">Numerico</option>
                        <option value="email">Email</option>
                    </select>
                </div>
            </div>

            <!-- Opciones (solo para select/radio) -->
            <div class="options-container hidden mb-2">
                <x-input-label class=" whitespace-nowrap" :value="__('Opciones (separadas por coma):')" />
                <x-text-input class="block mt-1 w-full" type="text" name="fields[__INDEX__][options]"
                    placeholder="Opción1,Opción2,Opción3" />
            </div>
            <div class="flex justify-between items-center px-4">
                <label class="flex gap-1 items-center">
                    <input type="checkbox" class="rounded" name="fields[__INDEX__][required]">
                    <x-input-label class="whitespace-nowrap" :value="__('Requerido')" />
                </label>
                <!-- Botón para eliminar el campo -->
                <button type="button" class="remove-field text-red-500 mt-2">Eliminar Campo</button>
            </div>
        </div>
    </template>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addFieldButton = document.getElementById('add-field');
            const fieldsContainer = document.getElementById('fields-container');
            const fieldTemplate = document.getElementById('field-template').content;
            let countFields = 0;

            // Función para agregar un nuevo campo
            addFieldButton.addEventListener('click', addField);

            function addField(element = null) {
                const newField = fieldTemplate.cloneNode(true);
                // Reemplazar __INDEX__ con el valor actual de countFields para cada campo
                const htmlString = new XMLSerializer().serializeToString(newField);
                const updatedHTML = htmlString.replace(/__INDEX__/g, countFields);

                // Crear un elemento temporal para insertar el nuevo campo
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = updatedHTML;
                const fieldElement = tempDiv.firstElementChild;

                if (element && element.type == "select") {
                    tempDiv.querySelector('.options - container').classList.remove('hidden');
                }

                // Añadir evento para mostrar las opciones cuando sea select o radio
                fieldElement.querySelector('select').addEventListener('change', function() {
                    const optionsContainer = this.closest('.field').querySelector(
                        '.options-container');
                    if (this.value === 'select' || this.value === 'radio') {
                        optionsContainer.classList.remove('hidden');
                    } else {
                        optionsContainer.classList.add('hidden');
                    }
                });

                // Añadir evento para eliminar un campo
                fieldElement.querySelector('.remove-field').addEventListener('click', function() {
                    this.closest('.field').remove();
                    countFields--;
                });

                // Insertar el nuevo campo en el contenedor
                fieldsContainer.appendChild(fieldElement);
                countFields++;
            }
            @if ($form->fieldsCount() > 0)
                const fields = @json($form->fields()->get());
                console.log(fields);
                fields.forEach(element => {
                    addField(element);
                });
            @endif
        });
    </script>

</x-admin-layout>
