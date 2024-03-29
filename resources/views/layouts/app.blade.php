<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex font-sans antialiased">
        <div class="flex flex-col min-h-screen max-w-full min-w-full bg-gray-800">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-gray-900 shadow">
                <div class="flex max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex flex-col flex-1">
                {{ $slot }}
            </main>
            <footer class="text-center text-gray-400 fixed bottom-0 inset-x-0">Powered by <a href="https://www.isthereanydeal.com">IsThereAnyDeal.com</a></footer>
        </div>
    </body>
</html>
