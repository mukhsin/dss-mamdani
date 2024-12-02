<?php

use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {

    public string $title;

    public $list_produk;
    public Penjualan $penjualan;
    public $produk_id;
    public $tgl_pesanan;
    public $harga_jual;
    public $qty;

    public $datepicker_config;

    public function mount(Penjualan $penjualan): void
    {
        $this->list_produk = Produk::orderBy('nama_produk')->get();
        $this->penjualan = $penjualan;
        $this->title = 'Tambah Penjualan';

        if ($this->penjualan->penjualan_id) {
            $this->title = 'Ubah Penjualan';
            $this->produk_id = $penjualan->produk_id;
            $this->tgl_pesanan = Carbon::createFromFormat('Y-m-d', $penjualan->tgl_pesanan)->format('d-m-Y');
            $this->harga_jual = $penjualan->harga_jual;
            $this->qty = $penjualan->qty;
        }

        $today = Carbon::today();
        $maxDate = $today->format('d-m-Y');
        $minDate = $today->copy()->subYears(5)->format('d-m-Y');

        $this->datepicker_config = [
            'altFormat' => 'd-m-Y',
            'dateFormat' => 'd-m-Y',
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ];
    }

    public function back(): void
    {
        if ($this->penjualan->penjualan_id) {
            redirect()->route('penjualan.show', ['penjualan_id' => $this->penjualan->penjualan_id]);
        } else {
            redirect()->route('penjualan.index');
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'produk_id' => ['required', 'integer'],
            'tgl_pesanan' => ['required', 'date_format:d-m-Y', 'before:today'],
            'harga_jual' => ['required', 'numeric'],
            'qty' => ['required', 'integer'],
        ]);

        $this->penjualan->produk_id = $validated['produk_id'];
        $this->penjualan->tgl_pesanan = Carbon::createFromFormat('d-m-Y', $validated['tgl_pesanan'])->format('Y-m-d');
        $this->penjualan->harga_jual = $validated['harga_jual'];
        $this->penjualan->qty = $validated['qty'];
        $this->penjualan->save();

        redirect()->route('penjualan.show', ['penjualan_id' => $this->penjualan->penjualan_id]);
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
        <x-mary-choices-offline
            single
            searchable
            label="{{ __('Pilih Produk') }}"
            placeholder="{{ __('Cari...') }}"
            wire:model="produk_id"
            :options="$list_produk"
        />
        <x-mary-datepicker
            label="{{ __('Tanggal Pesanan') }}"
            icon="o-calendar"
            :config="$datepicker_config"
            wire:model.live="tgl_pesanan"
        />
        <x-mary-input label="{{ __('Harga Jual') }}" wire:model="harga_jual" prefix="Rp"/>
        <x-mary-input label="{{ __('Qty') }}" wire:model="qty" suffix="pcs"/>

        <div class="flex gap-2">
            <x-mary-button label="{{ __('Simpan') }}" class="btn-primary" type="submit" spinner="save"/>
            <x-mary-button label="{{ __('Batal') }}" wire:click="back()" spinner/>
        </div>
    </x-mary-form>

</section>
