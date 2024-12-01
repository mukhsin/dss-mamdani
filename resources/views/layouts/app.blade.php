<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="{{ config('app.theme', 'dark') }}"

    {{-- x-data="{ darkMode: false }" --}}
    {{-- x-bind:class="{'dark' : darkMode === true}" x-init=" --}}
    {{-- if (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) { --}}
    {{--     localStorage.setItem('darkMode', JSON.stringify(true)); --}}
    {{-- } --}}
    {{-- darkMode = JSON.parse(localStorage.getItem('darkMode')); --}}
    {{-- $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))" --}}
    {{-- class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700" --}}

    {{-- x-data="{ --}}
    {{--   darkMode: localStorage.getItem('darkMode') --}}
    {{--   || localStorage.setItem('darkMode', 'system')}" --}}
    {{-- x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" --}}
    {{-- x-bind:class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}" --}}
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>

    <!-- Scripts -->
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',

        // Flatpickr
        'resources/css/flatpickr.min.css',
        'resources/js/flatpickr.js',
    ])

    @if(config('app.theme', 'dark') == 'dark')
        @vite([
            'resources/css/flatpickr.dark.css',
        ])
    @endif

</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <livewire:_layout.navigation/>

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>
</body>
</html>
