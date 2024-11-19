<x-app-layout>
    <main class=" pt-[95px]  h-screen px-6">
        <h1 class="text-xl uppercase tracking-wider font-semibold mb-5">Reseñas de nuestros usuarios</h1>
        <div class="container mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                <!-- Itera sobre las reseñas -->
                @foreach($reviews as $review)
                    <div class="bg-white shadow-md rounded-lg px-6 py-3 flex flex-col justify-between max-w-sm">
                        <p class="text-gray-700 text-center">{{ $review['review'] }}</p>
                        <div class="flex items-center justify-center">
                            <img src="{{ $review['photo'] }}" alt="Foto del usuario" class="w-8 h-8 rounded-full mr-4">
                            <div>
                                <!-- Nombre del usuario -->
                                <h2 class="text-lg font-semibold text-gray-800 tracking-wider">{{ $review['name']}}</h2>
                                <!-- Fecha de la reseña -->
                                <p class="text-gray-500 text-sm">{{ $review['date'] }} (<span>{{$review['rol']}}</span>)</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
</x-app-layout>