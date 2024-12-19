<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=OpenDyslexic:wght@400;700&display=swap">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/css/accessibility.css'])
    @livewireStyles
</head>
<body class="{{ $bodyClasses ?? '' }}">
    <div x-data="breakTimer">
        <!-- Your existing layout content -->

        <!-- Break Timer -->
        <div x-show="timeLeft > 0"
             x-transition
             class="fixed bottom-4 right-4 bg-white dark:bg-gray-800 p-4 rounded-lg shadow-lg">
            <div class="text-lg font-medium">Break Timer</div>
            <div class="text-2xl" x-text="formatTime()"></div>
            <button
                @click="stopTimer()"
                class="mt-2 px-3 py-1 text-sm bg-red-500 text-white rounded hover:bg-red-600"
            >
                Dismiss
            </button>
        </div>
    </div>

    @vite(['resources/js/app.js', 'resources/js/break-timer.js'])
    @livewireScripts
</body>
</html>
