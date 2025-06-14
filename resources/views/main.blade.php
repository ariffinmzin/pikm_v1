<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <div class="relative min-h-screen">
        <!-- Auth Navigation -->
        <div class="p-6 text-right">
            @auth
                <a href="{{ route('dashboard') }}"
                    class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Log
                    in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}"
                        class="ml-4 font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 focus:outline focus:outline-2 focus:rounded-sm focus:outline-blue-500">Register</a>
                @endif
            @endauth
        </div>

        <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-[calc(100vh-8rem)] px-4">
            <div class="text-center space-y-8">
                <div class="flex justify-center">
                    <img src="{{ asset('images/pikm-logo-featured2.png') }}" alt="PIKM Logo"
                        class="w-64 h-auto md:w-96 object-contain" />
                </div>

                <h1 class="text-2xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 tracking-wider">
                    PERSATUAN INDUSTRI KESELAMATAN MALAYSIA
                </h1>

                <div class="w-24 h-1 mx-auto bg-blue-600 dark:bg-blue-500"></div>

                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-400">
                    {{ __('Malaysian Security Industry Association') }}
                </p>
            </div>
        </div>
    </div>
</body>

</html>
