<x-admin-layout>
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

    <div class="py-12 flex items-center justify-center w-full h-full max-h-screen">
        <div class="max-w-7xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white flex overflow-hidden shadow-sm sm:rounded-lg relative">
                <img width="100%" class="absolute bottom-0 opacity-75" src="{{ asset('/storage/images/wave.svg') }}"
                    alt="decoratives-waves">
                <div class="z-10 p-4 flex-1 flex flex-col gap-3 items-center justify-center relative">
                    <h1 class="text-4xl uppercase text-center tracking-widest montserrat-regular">Importar desde un
                        archivo</h1>
                    <p class="">
                        Solo sube un archivo .csv o excel con el siguiente formateo (contraseña default o definida) y
                        nosotros haremos el resto.
                    </p>
                    <p class="text-gray-800 text-sm font-medium">
                        <span class="text-red-500 font-semibold">Nota:</span> El archivo Excel debe contener las
                        siguientes columnas en la **primera fila**, con los nombres exactamente como se indican:
                    </p>
                    <div class="text-sm text-gray-700 flex gap-5 items-center justify-center flex-wrap">
                        <li><span class="text-red-500">*</span> <strong>nombre</strong> (Obligatorio)</li>
                        <li><span class="text-red-500">*</span> <strong>apellidos</strong> (Obligatorio)</li>
                        <li><span class="text-red-500">*</span> <strong>correo</strong> (Obligatorio)</li>
                        <li><span class="text-red-500">*</span> <strong>puesto</strong> (Obligatorio)</li>
                        <li><strong>password</strong> (Opcional, se te pedira un valor por defecto si no se incluye esta
                            columna)</li>
                    </div>
                    <p class="mt-2 text-gray-700 text-sm">
                        Asegúrate de que los nombres de las columnas estén correctamente escritos y sin espacios
                        adicionales, ya que el sistema valida los datos basándose en estos nombres.
                    </p>
                    <x-carrousel class="max-w-2xl w-full" startAtEnd="{{ !$errors->isEmpty() }}">
                        <div class="swiper-slide p-5 card space-y-3">
                            <p class="text-center text-sm tracking-widest">Contraseña Definida</p>
                            <img class="rounded-sm" src="{{ asset('/storage/images/formato-excel-1.png') }}"
                                alt="formateo-excel">
                        </div>
                        <div class="swiper-slide p-5 card space-y-3">
                            <p class="text-center text-sm tracking-widest">Contraseña Default</p>
                            <img class="rounded-sm" src="{{ asset('/storage/images/formato-excel-2.png') }}"
                                alt="formateo-excel">
                        </div>
                        <div class="swiper-slide">
                            <form action="{{ route('users.import.register') }}" method="POST"
                                enctype="multipart/form-data" class="flex flex-col justify-center gap-4"
                                x-data="{ formateo: {{ $errors->get('password') ? "'default'" : 'null' }} }">
                                @csrf
                                <!-- Tipo de formateo -->
                                <p class=" tracking-widest font-semibold">Tipo de formateo</p>
                                <div>
                                    <div class="flex gap-5">
                                        <div class="flex gap-2 cursor-pointer">
                                            <x-input-label for="definido" class="quicksand-body" :value="__('Contraseña definida')" />
                                            <input id="definido" type="radio" name="formateo" value="definido"
                                                x-model="formateo" required />
                                        </div>
                                        <div class="flex gap-2 cursor-pointer">
                                            <x-input-label for="default" class="quicksand-body" :value="__('Contraseña default')" />
                                            <input id="default" type="radio" name="formateo" value="default"
                                                x-model="formateo" required />
                                        </div>
                                    </div>
                                    <div x-show="formateo == 'default'" class="mt-5">
                                        <x-input-label for="password" class="quicksand-body" :value="__('Contraseña default para todas las cuentas')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="text"
                                            name="password" x-required="formateo == 'default'" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>


                                </div>
                                <p class=" tracking-widest font-semibold">Archivo</p>
                                <x-file-input input_id="excel_usuarios" types=".csv,.xlsx">
                                    <div class="h-full w-full text-center flex flex-col items-center justify-center">
                                        <lottie-player src="{{ asset('storage/images/file-animation.json') }}"
                                            background="transparent" speed="1" style="width: 100%; height: 150px;"
                                            loop autoplay>
                                        </lottie-player>
                                        <p class="pointer-none text-gray-500 text-xs ">
                                            <strong class="text-sm">Arrasta y suelta</strong>
                                            archivos .csv o .xsl aqui <br /> o <span
                                                class="text-blue-600 hover:underline">Selecciona un
                                                archivo</span> de tu computadora
                                        </p>
                                    </div>
                                </x-file-input>
                                <x-input-error :messages="$errors->get('excel_usuarios')" class="mt-2" />
                                <x-primary-button>Registrar usuarios</x-primary-button>
                            </form>
                        </div>

                    </x-carrousel>
                </div>
            </div>
        </div>
    </div>

    </x-app-layout>
