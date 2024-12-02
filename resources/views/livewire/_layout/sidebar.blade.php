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

<div class="flex flex-col h-full">
    <div class="flex-none">
        {{-- BRAND --}}
        <div :class="collapsed
                        ? 'hidden p-4 ms-2 text-xs text-nowrap font-light border-b border-gray-200 transition-all'
                        : 'flex p-4 ms-2 text-xl text-nowrap font-bold border-b border-gray-200 transition-all'
                ">
            {{ config('app.name', 'Laravel') }}
        </div>
        <div :class="collapsed
                        ? 'flex py-4 px-2 ms-2 text-xl font-bold border-b border-gray-200'
                        : 'hidden p-4 ms-2 text-xl font-bold border-b border-gray-200'
                ">
            DSS
        </div>
    </div>

    <div class="flex-grow">
        {{-- MENU --}}
        <x-mary-menu activate-by-route class="flex flex-col h-full">
            <div class="flex-1">
                <x-mary-menu-item title="Home" icon="o-home" link="/"/>
                <x-mary-menu-sub title="Data Master" icon="o-list-bullet">
                    <x-mary-menu-item title="Data Produk" icon="o-document" link="/produk"/>
                    <x-mary-menu-item title="Data Penjualan" icon="o-document" link="/penjualan"/>
                </x-mary-menu-sub>
                <x-mary-menu-sub title="Dashboard" icon="o-cog-6-tooth">
                    <x-mary-menu-item title="Rekomendasi Diskon" icon="o-receipt-percent" link="/rekomendasi/halaman1"/>
                    <x-mary-menu-item title="Riwayat Perhitungan" icon="o-calculator" link="/rekomendasi/riwayat"/>
                </x-mary-menu-sub>
            </div>

            <div class="">
                {{-- User --}}
                @if($user = auth()->user())
                    <x-mary-menu-separator/>
                    <x-mary-list-item
                        :item="$user"
                        value="name"
                        sub-value="email"
                        class="-mx-mary-2 !-my-2 rounded"
                        no-separator
                        no-hover
                    >
                        <x-slot:actions>
                            <x-mary-button
                                wire:click="logout"
                                icon="o-arrow-right-on-rectangle"
                                class="btn-circle btn-ghost btn-sm"
                            />
                        </x-slot:actions>
                    </x-mary-list-item>
                @endif
            </div>
        </x-mary-menu>
    </div>
</div>
