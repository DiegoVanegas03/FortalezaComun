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
                        Solo sube un archivo .csv o excel con el siguiente formateo y nosotros haremos el resto.
                    </p>
                    <x-carrousel class="max-w-2xl w-full">
                        <div class="swiper-slide card">
                            <div class="h-full rounded-2xl flex flex-1 justify-center items-center">
                                <span class="text-3xl font-semibold text-indigo-600">Slide 2 </span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="bg-indigo-50 rounded-2xl flex justify-center items-center">
                                <span class="text-3xl font-semibold text-indigo-600">Slide 3 </span>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <x-file-input input_id="excel-id" types=".csv,.xlsx">
                                <div class="h-full w-full text-center flex flex-col items-center justify-center">
                                    <lottie-player src="{{ asset('storage/images/file-animation.json') }}"
                                        background="transparent" speed="1" style="width: 100%; height: 150px;" loop
                                        autoplay>
                                    </lottie-player>
                                    <p class="pointer-none text-gray-500 text-xs ">
                                        <strong class="text-sm">Arrasta y suelta</strong>
                                        archivos .csv o .xsl aqui <br /> o <span
                                            class="text-blue-600 hover:underline">Selecciona un
                                            archivo</span> de tu computadora
                                    </p>
                                </div>
                            </x-file-input>
                        </div>

                    </x-carrousel>
                </div>
            </div>
        </div>
    </div>

    </x-app-layout>
