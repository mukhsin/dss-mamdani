<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" wire:navigate>
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link
                        wire:navigate
                        :href="route('produk.index')"
                        :active="request()->routeIs('produk.index', 'produk.create', 'produk.show', 'produk.edit')"
                    >
                        {{ __('Produk') }}
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link
                        wire:navigate
                        :href="route('penjualan.index')"
                        :active="request()->routeIs('penjualan.index', 'penjualan.create', 'penjualan.show', 'penjualan.edit')"
                    >
                        {{ __('Penjualan') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center gap-2 sm:ms-6">
                {{-- <div class="hidden dark:flex"> --}}
                {{--     My SVG if theme is dark --}}
                {{-- </div> --}}
                {{-- <div class="flex dark:hidden"> --}}
                {{--     My SVG if theme is light --}}
                {{-- </div> --}}

                <!-- Darkmode Toggler -->
                {{-- <button x-on:click="darkMode = !darkMode" type="button" class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none rounded-lg text-sm p-2.5"> --}}
                {{--     <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> --}}
                {{--         <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path> --}}
                {{--     </svg> --}}
                {{--     <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"> --}}
                {{--         <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path> --}}
                {{--     </svg> --}}
                {{-- </button> --}}

                {{-- <div x-cloak class="relative inline-flex items-center gap-2 mr-2 sm:pb-2"> --}}
                {{--      --}}{{-- light --}}
                {{--     <button x-on:click="darkMode = 'light'"> --}}
                {{--         <svg xmlns="http://www.w3.org/2000/svg" --}}
                {{--              x-bind:class="{'border-2 border-red/50': darkMode === 'light'}" --}}
                {{--              class="w-6 h-6 p-1 text-gray-700 transition rounded-full cursor-pointer bg-gray-50 hover:bg-gray-200" --}}
                {{--              fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> --}}
                {{--             <path stroke-linecap="round" stroke-linejoin="round" --}}
                {{--                   d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/> --}}
                {{--         </svg> --}}
                {{--         <span class="sr-only">light</span> --}}
                {{--     </button> --}}
                {{--      --}}{{-- dark --}}
                {{--     <button x-on:click="darkMode = 'dark'"> --}}
                {{--         <svg xmlns="http://www.w3.org/2000/svg" --}}
                {{--              x-bind:class="{'border-2 border-red/50': darkMode === 'dark'}" --}}
                {{--              class="w-6 h-6 p-1 text-gray-100 transition bg-gray-700 rounded-full cursor-pointer dark:hover:bg-gray-600" --}}
                {{--              viewBox="0 0 20 20" fill="currentColor"> --}}
                {{--             <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/> --}}
                {{--         </svg> --}}
                {{--         <span class="sr-only">dark</span> --}}
                {{--     </button> --}}
                {{--      --}}{{-- system --}}
                {{--     <button x-on:click="darkMode = 'system'"> --}}
                {{--         <svg --}}
                {{--             xmlns="http://www.w3.org/2000/svg" --}}
                {{--             x-cloak --}}
                {{--             x-show="! window.matchMedia('(prefers-color-scheme: dark)').matches" --}}
                {{--             x-bind:class="{'border-2 border-red/50': darkMode === 'system'}" --}}
                {{--             class="w-6 h-6 p-1 text-gray-700 transition bg-gray-100 rounded-full cursor-pointer hover:bg-gray-200" --}}
                {{--             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> --}}
                {{--             <path stroke-linecap="round" stroke-linejoin="round" --}}
                {{--                   d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/> --}}
                {{--             <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/> --}}
                {{--         </svg> --}}
                {{--         <svg --}}
                {{--             xmlns="http://www.w3.org/2000/svg" --}}
                {{--             x-show="window.matchMedia('(prefers-color-scheme: dark)').matches" --}}
                {{--             x-bind:class="{'border-2 border-red/50': darkMode === 'system'}" --}}
                {{--             class="w-6 h-6 p-1 text-gray-100 transition bg-gray-700 rounded-full cursor-pointer dark:hover:bg-gray-600" --}}
                {{--             x-cloak --}}
                {{--             fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"> --}}
                {{--             <path stroke-linecap="round" stroke-linejoin="round" --}}
                {{--                   d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/> --}}
                {{--             <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/> --}}
                {{--         </svg> --}}
                {{--         <span class="sr-only">system</span> --}}
                {{--     </button> --}}
                {{-- </div> --}}

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                                 x-on:profile-updated.window="name = $event.detail.name"></div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile')" wire:navigate>
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                              stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200"
                     x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name"
                     x-on:profile-updated.window="name = $event.detail.name"></div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile')" wire:navigate>
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
