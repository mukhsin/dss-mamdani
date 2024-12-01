<?php

use App\Models\Penjualan;
use Livewire\Volt\Component;

new class extends Component {

    public Penjualan $penjualan;

    public bool $modalPenjualanDelete = false;

    public function mount(Penjualan $penjualan): void
    {
        $this->penjualan = $penjualan;
    }

    public function back(): void
    {
        redirect()->route('penjualan.index');
    }

    public function edit(): void
    {
        redirect()->route('penjualan.edit', ['penjualan_id' => $this->penjualan->penjualan_id]);
    }

    public function delete(): void
    {
        $this->penjualan->delete();
        redirect()->route('penjualan.index');
    }

    public function openModalPenjualanDelete(): void
    {
        $this->modalPenjualanDelete = true;
    }

    public function closeModalPenjualanDelete(): void
    {
        $this->modalPenjualanDelete = false;
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <div class="flex items-center gap-2">
            <x-mary-button
                icon="o-chevron-left"
                class="btn-circle btn-ghost"
                wire:click="back()"
            />
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Detail Penjualan') }}
            </h2>
        </div>

        <div class="flex gap-2">
            <x-mary-button
                spinner
                icon="o-pencil"
                label="Ubah"
                wire:click="edit({{ $penjualan->penjualan_id }})"
            />
            <x-mary-button
                spinner
                icon="o-trash"
                label="Hapus"
                class="btn-error"
                wire:click="openModalPenjualanDelete()"
            />
        </div>
    </header>

    <table class="table">
        <tbody>
        <tr class="hover:bg-base-200/50">
            <td>Tanggal Pesanan</td>
            <td>{{ $penjualan->tanggal_pesanan }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Nama Produk</td>
            <td>{{ $penjualan->produk->nama_produk }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Harga Jual</td>
            <td>@uang($penjualan->harga_jual)</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Qty (pcs)</td>
            <td>{{ $penjualan->qty }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Total Harga</td>
            <td>@uang($penjualan->total_harga)</td>
        </tr>
        </tbody>
    </table>

    <x-mary-modal wire:model="modalPenjualanDelete" title="Hapus Penjualan">
        {{ __('Yakin ingin menghapus penjualan ' . __($penjualan->nama_penjualan) . '?') }}
        <x-slot:actions>
            <x-mary-button
                label="Batal"
                wire:click="closeModalPenjualanDelete()"
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
