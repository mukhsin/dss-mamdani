<?php

use App\Models\Produk;
use Livewire\Volt\Component;

new class extends Component {

    public string $title;

    public Produk $produk;
    public $nama_produk;
    public $berat_produk;
    public $harga_modal;
    public $harga_jual;

    public function mount(Produk $produk): void
    {
        $this->produk = $produk;
        $this->title = 'Tambah Produk';

        if ($this->produk->produk_id) {
            $this->title = 'Ubah Produk';
            $this->nama_produk = $produk->nama_produk;
            $this->berat_produk = $produk->berat_produk;
            $this->harga_modal = $produk->harga_modal;
            $this->harga_jual = $produk->harga_jual;
        }
    }

    public function back(): void
    {
        if ($this->produk->produk_id) {
            redirect()->route('produk.show', ['produk_id' => $this->produk->produk_id]);
        } else {
            redirect()->route('produk.index');
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'nama_produk' => ['required', 'string', 'max:255'],
            'berat_produk' => ['required', 'integer'],
            'harga_modal' => ['required', 'numeric'],
            'harga_jual' => ['required', 'numeric'],
        ]);

        $this->produk->nama_produk = $validated['nama_produk'];
        $this->produk->berat_produk = $validated['berat_produk'];
        $this->produk->harga_modal = $validated['harga_modal'];
        $this->produk->harga_jual = $validated['harga_jual'];
        $this->produk->save();

        redirect()->route('produk.show', ['produk_id' => $this->produk->produk_id]);
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
                {{ __( $title ) }}
            </h2>
        </div>
    </header>

    <x-mary-form wire:submit="save" class="px-4" no-separator>
        <x-mary-input label="{{ __('Jenis Produk') }}" wire:model="nama_produk"/>
        <x-mary-input label="{{ __('Berat Produk') }}" wire:model="berat_produk" suffix="gram"/>
        <x-mary-input label="{{ __('Harga Modal') }}" wire:model="harga_modal" prefix="Rp"/>
        <x-mary-input label="{{ __('Harga Jual') }}" wire:model="harga_jual" prefix="Rp"/>

        <div class="flex gap-2">
            <x-mary-button label="{{ __('Simpan') }}" class="btn-primary" type="submit" spinner="save"/>
            <x-mary-button label="{{ __('Batal') }}" wire:click="back()" spinner/>
        </div>
    </x-mary-form>

</section>
