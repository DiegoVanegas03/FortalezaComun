<x-app-layout>
    <main class=" pt-[95px]  h-screen px-6 flex flex-col">
        <h1
            class="text-4xl text-center tracking-wider montserrat-regular montserrat-bold uppercase tracking-in-contract-bck whitespace-nowrap mb-5">
            Lo que nuestros usuarios dicen
        </h1>
        <p class="text-center text-lg">Por que tu opinion es lo mas importante para nosotros</p>
        <div class="container mx-auto grid grid-cols-3 gap-4 mt-6 flex-1 pb-6">
            @if (!$exists)
                <div class="cols-span-1 bg-white rounded-xl shadow-xl flex flex-col gap-4 p-4 h-fit relative group">
                    <p class="text-center font-semibold text-lg">Ayudanos a mejorar</p>

                    <form method="post" action="{{ route('reviews.add') }}" class="w-full grid grid-cols-1 gap-4">
                        @auth
                            @csrf
                            <p>
                                <span class="font-semibold">Usuario: </span>
                                {{ Auth::user()->nombreCompleto() }}
                            </p>
                            <p>
                                <span class="font-semibold mb-2">Rol que desenvuelve: </span>
                                {{ Auth::user()->rol }}
                            </p>
                            <p class="tracking-wider">
                                ¿Qué opinas de nosotros?
                            </p>
                        @endauth
                        <textarea name="review" id="review" placeholder="Reseña..." rows="5" class="rounded-lg border resize-none"></textarea>
                        <x-input-error :messages="$errors->get('review')" class="mt-2" />
                        <x-primary-button type="submit"
                            class="w-full text-center h-10 justify-center  text-white rounded-lg p-3 text-lg">
                            Guardar
                        </x-primary-button>
                    </form>
                    @guest
                        <div
                            class="absolute inset-0 bg-gray-600 rounded-xl bg-opacity-50 z-10 opacity-0 group-hover:opacity-100 transition-opacity">
                        </div>
                        <p
                            class="absolute inset-x-0 inset-y-0 text-center text-xl font-bold text-gray-600 opacity-0 group-hover:opacity-100 z-20 flex items-center justify-center transition-opacity">
                            Inicia sesión para dejar una reseña
                        </p>
                    @endguest
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-2 grid-rows-3 gap-2 col-span-2">
                @foreach ($reviews as $review)
                    <div
                        class="bg-white shadow-md rounded-lg px-6 py-3 flex items-center flex-col justify-between w-full">
                        <img src="{{ $review['photo'] }}" alt="Foto del usuario" class=" w-20 rounded-full mr-4">
                        <p class="text-md font-semibold italic">{{ $review->nombre() }}</p>
                        <p class="text-gray-700 min-h-14 w-full">{{ $review['review'] }}</p>
                        <div class="flex items-center justify-center">
                            <div>
                                <!-- Nombre del usuario -->
                                <h2 class="text-lg font-semibold text-gray-800 tracking-wider">
                                    {{ $review['name'] }}
                                </h2>
                                <!-- Fecha de la reseña -->
                                <p class="text-gray-500 text-sm">{{ $review['date'] }}
                                    (<span>{{ $review->rol() }}</span>)
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-app-layout>
