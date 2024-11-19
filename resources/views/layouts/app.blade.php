<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="montserrat-regular antialiased min-h-screen bg-app-primary">
        @include('layouts.navigation')
        <!-- Page Content -->
        {{ $slot }}
        <footer class="bg-[#072c64] py-5 text-white">
            <div class="container mx-auto text-center">
                <p class="text-lg font-semibold uppercase tracking-widest">Fortaleza Común</p>
                <p class="text-sm mt-2">© 2024 Fortaleza Común. Todos los derechos reservados.</p>
                <p class="text-sm">Cumpliendo con la <a href="#" class="underline text-blue-400 hover:text-blue-600">Ley Federal de Protección de Datos Personales</a></p>
            </div>
        </footer>
        
    </body>
</html>