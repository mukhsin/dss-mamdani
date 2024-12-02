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

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">
{{-- NAVBAR mobile only --}}
<x-mary-nav sticky class="lg:hidden">
    <x-slot:brand>
        {{-- <div class="p-4 ms-2 text-xl font-bold border-b border-gray-200"> --}}
        {{ config('app.name', 'Laravel') }}
        {{-- </div> --}}
    </x-slot:brand>
    <x-slot:actions>
        <label for="main-drawer" class="lg:hidden">
            <x-mary-icon name="o-bars-3" class="cursor-pointer"/>
        </label>
    </x-slot:actions>
</x-mary-nav>

{{-- MAIN --}}
<x-mary-main full-width>
    {{-- SIDEBAR --}}
    <x-slot:sidebar
        drawer="main-drawer"
        class="bg-base-100 lg:bg-inherit"
        collapsible
        collapse-icon="o-bars-3"
    >
        <livewire:_layout.sidebar/>
    </x-slot:sidebar>

    {{-- The `$slot` goes here --}}
    <x-slot:content>
        {{ $slot }}
    </x-slot:content>
</x-mary-main>

{{-- Toast --}}
<x-mary-toast/>
</body>
</html>
