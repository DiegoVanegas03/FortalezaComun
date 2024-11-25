<x-app-layout>
    <main class=" pt-[95px] grid lg:grid-cols-2 place-items-center gap-5 h-screen">
        <div class="flex flex-col justify-center text-app-secondary montserrat-light uppercase tracking-widest">
            <p class="text-[2.5rem] md:text-[3rem] tracking-in-contract-bck ">a tu alcance</p>
            <p class="text-[2.5rem]  md:text-[5rem] font-extrabold tracking-in-contract-bck ">FORTALEZA</p>
            <p class="text-[2.5rem]  md:text-[5rem] font-extrabold tracking-in-contract-bck ">COMÚN</p>
            <a href="/reseñas"
                class="py-6 bg-yellow-400 text-center text-xl drop-shadow-xl font-semibold rounded-xl text-black">
                DESCÚBRELO
            </a>
        </div>
        <div class="flex items-end justify-end h-full ">
            <img class="rounded-full md:w-[700px] lg:w-[900px] p-4 rotate-in-2-fwd-cw"
                src="{{ asset('/storage/images/3D-pentagono 1.png') }}" />
        </div>
    </main>
</x-app-layout>
