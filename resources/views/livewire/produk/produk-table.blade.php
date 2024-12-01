<?php

use App\Models\Produk;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component {

    use \Livewire\WithPagination;

    public int $selectedId = 0;
    public string $selectedName = '';

    public bool $modalProdukDelete = false;

    #[Url(history: true, keep: true)]
    public $page = 1;
    public $perPage = 10;

    public function with(): array
    {
        return [
            'list_produk' => Produk::orderBy('nama_produk')->paginate($this->perPage),
            'headers' => [
                ['key' => 'no', 'label' => '#'],
                ['key' => 'nama_produk', 'label' => 'Nama Produk'],
                ['key' => 'berat_produk', 'label' => 'Berat Produk (gram)', 'class' => 'text-right'],
                ['key' => 'harga_modal', 'label' => 'Harga Modal', 'class' => 'text-right'],
                ['key' => 'aksi', 'label' => 'Aksi', 'class' => 'text-center w-48'],
            ],
        ];
    }

    public function create(): void
    {
        redirect()->route('produk.create');
    }

    public function show($id): void
    {
        redirect()->route('produk.show', ['produk_id' => $id]);
    }

    public function edit($id): void
    {
        redirect()->route('produk.edit', ['produk_id' => $id]);
    }

    public function delete(): void
    {
        Produk::find($this->selectedId)->delete();
        redirect()->route('produk.index');
    }

    public function openModalProdukDelete($id, $name): void
    {
        $this->modalProdukDelete = true;
        $this->selectedId = $id;
        $this->selectedName = $name;
    }

    public function closeModalProdukDelete(): void
    {
        $this->modalProdukDelete = false;
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <h2 class="text-lg mb-4 font-medium text-gray-900 dark:text-gray-100">
            {{ __('Data Produk') }}
        </h2>
        <x-mary-button
            icon="o-plus"
            label="Tambah Produk"
            wire:click="create"
        />
    </header>

    <x-mary-table
        :headers="$headers"
        :rows="$list_produk"
        with-pagination
        per-page="perPage"
        :per-page-values="[10, 20, 50, 100]"
    >
        @scope('cell_no', $produk, $page, $perPage)
        {{ $loop->iteration + (($page - 1) * $perPage) }}
        @endscope

        @scope('cell_harga_modal', $produk)
        @uang($produk->harga_modal)
        @endscope

        @scope('cell_aksi', $produk)
        <div class="flex gap-2 justify-center">
            <x-mary-button
                spinner
                icon="o-eye"
                tooltip="Lihat"
                class="btn-sm btn-circle btn-ghost"
                wire:click="show({{ $produk->produk_id }})"
            />
            <x-mary-button
                spinner
                icon="o-pencil"
                tooltip="Ubah"
                class="btn-sm btn-circle btn-ghost"
                wire:click="edit({{ $produk->produk_id }})"
            />
            <x-mary-button
                spinner
                icon="o-trash"
                tooltip="Hapus"
                class="btn-sm btn-circle btn-ghost btn-error"
                wire:click="openModalProdukDelete({{ $produk->produk_id }}, '{{ __($produk->nama_produk) }}')"
            />
        </div>
        @endscope
    </x-mary-table>

    <x-mary-modal wire:model="modalProdukDelete" title="Hapus Produk">
        {{ __('Yakin ingin menghapus produk ' . $selectedName . '?') }}
        <x-slot:actions>
            <x-mary-button
                label="Batal"
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
