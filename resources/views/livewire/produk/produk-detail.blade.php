<?php

use App\Models\Produk;
use Livewire\Volt\Component;

new class extends Component {

    public Produk $produk;

    public bool $modalProdukDelete = false;

    public function mount(Produk $produk): void
    {
        $this->produk = $produk;
    }

    public function back(): void
    {
        redirect()->route('produk.index');
    }

    public function edit(): void
    {
        redirect()->route('produk.edit', ['produk_id' => $this->produk->produk_id]);
    }

    public function delete(): void
    {
        $this->produk->delete();
        redirect()->route('produk.index');
    }

    public function openModalProdukDelete(): void
    {
        $this->modalProdukDelete = true;
    }

    public function closeModalProdukDelete(): void
    {
        $this->modalProdukDelete = false;
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between pb-6 border-b border-gray-100 dark:border-gray-900">
        <div class="flex items-center gap-2">
            {{-- <x-mary-button
                icon="o-chevron-left"
                class="btn-circle btn-ghost"
                wire:click="back()"
            /> --}}
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Detail Produk') }}
            </h2>
        </div>

        <div class="flex gap-2">
            <x-mary-button
                spinner
                icon="o-chevron-left"
                label="Kembali"
                wire:click="back()"
            />
            <x-mary-button
                spinner
                icon="o-pencil"
                label="Ubah"
                wire:click="edit({{ $produk->produk_id }})"
            />
            <x-mary-button
                spinner
                icon="o-trash"
                label="Hapus"
                class="btn-error"
                wire:click="openModalProdukDelete()"
            />
        </div>
    </header>

    <table class="table">
        <tbody>
        <tr class="hover:bg-base-200/50">
            <td>Nama Produk</td>
            <td>{{ $produk->nama_produk }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Berat Produk (gram)</td>
            <td>{{ $produk->berat_produk }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Harga Modal</td>
            <td>@uang($produk->harga_modal)</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Harga Jual</td>
            <td>@uang($produk->harga_jual)</td>
        </tr>
        </tbody>
    </table>

    <x-mary-modal wire:model="modalProdukDelete" title="Hapus Produk">
        {{ __('Yakin ingin menghapus produk ' . __($produk->nama_produk) . '?') }}
        <x-slot:actions>
            <x-mary-button
                spinner
                label="{{ __('Batal') }}"
                wire:click="closeModalProdukDelete()"
            />
            <x-mary-button
                spinner="delete"
                label="Hapus"
                class="btn-error"
                wire:click="delete()"
            />
        </x-slot:actions>
    </x-mary-modal>

</section>
