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
<div class="min-h-screen bg-purple-300">
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
                <div class="w-72 flex-shrink-0 py-5 ">
                    <x-sidebar />
                </div>

                <!-- Main Content Area -->
                <div class="flex-1 overflow-x-hidden">
                    <div class="container mx-auto px-6 py-8">
                        <div class="bg-white overflow-hidden shadow-xl rounded-3xl border border-gray-100">
                            <main class="p-8">
                                {{ $slot }}
                            </main>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Footer -->
        <footer class="bg-white  border-gray-200 mt-8">
            <div class="max-w-7xl mx-auto px-4 py-6 flex flex-col sm:flex-row justify-between items-center text-gray-500 text-sm">
                <div>
                    &copy; {{ date('Y') }} Taska Childcare Management System. All rights reserved.
                </div>
                <div>
                    Made with <span class="text-red-500">&hearts;</span> by your team.
                </div>
            </div>
        </footer>
        
        <!-- This is the fix: Load scripts pushed from other views -->
        @stack('scripts')
    </body>
</html>