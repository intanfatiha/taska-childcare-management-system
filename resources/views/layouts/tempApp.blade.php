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
        

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Top Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main Layout Container -->
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 flex-shrink-0">
                    <x-sidebar />
                </div>

                <!-- Main Content Area -->
                <div class="flex-1 overflow-x-hidden">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <main class="p-6">
                                {{ $slot }}
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
           <!-- This is the fix: Load scripts pushed from other views -->
           @stack('scripts') 
    </body>
</html>