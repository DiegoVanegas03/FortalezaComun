<x-admin-layout>
    <div class="py-12 flex items-center justify-center w-full h-full min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-2xl flex-1 uppercase tracking-widest">Reporte con IA de las respuestas de los formularios
            </h1>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-hidden overflow-x-auto p-6 bg-white border-b border-gray-200">
                    <div>
                        <x-input-label for="formId" :value="__('Selecciona un formulario:')" />
                        <x-select-input id="formId" class="block mt-1 w-full" :options="$forms" :requerido="false"
                            selected="" />
                    </div>
                    <div class="py-2 space-y-6 ">
                        <h2 class="uppercase text-center italic font-bold">Retroalimentacion</h2>
                        {!! $analysis ?? '' !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    </x-app-layout>
    <script>
        document.getElementById('formId').addEventListener('change', function() {
            const selectedValue = this.value; // Obtén el valor seleccionado
            const baseUrl = "{{ route('forms.analyze.form', ':id') }}"; // Ruta con un marcador
            const route = baseUrl.replace(':id', selectedValue); // Reemplaza el marcador con el valor seleccionado
            window.location.href = route; // Redirige a la ruta
        });
    </script>
