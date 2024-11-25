@props(['input_id', 'types', 'error'])
<label id="drop-area-{{ $input_id }}" for="{{ $input_id }}" ondrop="handleDrop(event)"
    ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)"
    class="flex cursor-pointer flex-col card  rounded-lg max-w-2xl w-full h-60 p-10 group text-center">

    <input id="{{ $input_id }}" type="file" class="hidden" accept="{{ $types }}" name="{{ $input_id }}">

    <div id="originalContent-{{ $input_id }}" class="h-full w-full">
        {{ $slot }}
    </div>
    <div id="info-file-{{ $input_id }}" class="hidden flex-col gap-4 flex-1 items-center justify-center w-full">
        <div class="h-full w-full text-left flex flex-col gap-3 items-center justify-center text-gray-500 text-xs">
            <p></p>
        </div>
        <x-danger-button type="button" class="justify-center" onclick="eliminararchivo()">
            Eliminar este archivo
        </x-danger-button>
    </div>

    <script>
        function handleDragOver(event) {
            event.preventDefault();
            event.stopPropagation();
            document.getElementById('drop-area-{{ $input_id }}').classList.add('opacity-50');
        }

        function handleDragLeave(event) {
            event.preventDefault();
            event.stopPropagation();
            document.getElementById('drop-area-{{ $input_id }}').classList.remove('opacity-50');
        }

        function eliminararchivo() {
            document.getElementById("{{ $input_id }}").value = '';
            const originalContent = document.getElementById('originalContent-{{ $input_id }}');
            // Ocultar el contenido original
            originalContent.classList.remove('hidden');
            const infoFile = document.getElementById('info-file-{{ $input_id }}');
            infoFile.classList.add('hidden');
            document.getElementById('drop-area-{{ $input_id }}').setAttribute('for', '{{ $input_id }}');
        }

        function handleFileChange(event) {
            const files = event.target.files;
            const originalContent = document.getElementById('originalContent-{{ $input_id }}');
            // Ocultar el contenido original
            originalContent.classList.add('hidden');

            const infoFile = document.getElementById('info-file-{{ $input_id }}');
            infoFile.querySelector('p').innerHTML = `                
                <strong class ='text-sm'>Nombre del archivo:</strong> ${files[0].name}<br>
                <strong class ='text-sm'>Peso:</strong> ${(files[0].size / (1024)).toFixed(2)} KB<br>
                <strong class ='text-sm'>Tipo:</strong> ${files[0].type}`;
            // Mostrar el área de información del archivo
            infoFile.classList.remove('hidden');
            document.getElementById('drop-area-{{ $input_id }}').setAttribute('for', '');
        }

        // Maneja el drop del archivo
        function handleDrop(event) {
            event.preventDefault();
            event.stopPropagation();
            // Revertir el cambio en el fondo
            document.getElementById('drop-area-{{ $input_id }}').classList.remove('opacity-50');
            const files = event.dataTransfer.files; // Archivos arrastrados
            if (files.length > 0) {
                document.getElementById("{{ $input_id }}").files = files; // Establecer archivos en el input oculto
                handleFileChange({
                    target: document.getElementById("{{ $input_id }}")
                });
            }
        }
        document.getElementById("{{ $input_id }}").addEventListener('change', handleFileChange);
    </script>
</label>
