<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="quicksand-body antialiased  bg-gray-100">
    <!-- Page Content -->
    <x-sidebar-navigate :items="[
        ['label' => 'Inicio', 'route' => 'home', 'icon' => 'fa-solid fa-house'],
        ['label' => 'Usuarios', 'route' => 'users.index', 'icon' => 'fa-solid fa-user'],
        ['label' => 'Formularios', 'route' => 'forms.index', 'icon' => 'fa-solid text-xl fa-clipboard-question'],
        ['label' => 'Chat-GPT', 'route' => 'forms.analyze', 'icon' => 'fa-solid fa-robot'],
    ]">
        {{ $slot }}
    </x-sidebar-navigate>
    <footer class="bg-white py-6">
        <div class="container mx-auto text-center">
            <p class="text-lg font-semibold uppercase tracking-widest">Fortaleza Común</p>
            <p class="text-sm mt-2">© 2024 Fortaleza Común. Todos los derechos reservados.</p>
            <p class="text-sm">Cumpliendo con la <a href="#"
                    class="underline text-blue-400 hover:text-blue-600">Ley Federal de Protección de Datos
                    Personales</a></p>
        </div>
    </footer>
</body>

</html>
