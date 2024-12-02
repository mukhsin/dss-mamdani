<?php

use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component {

    use \Livewire\WithPagination;

    public int $selectedId = 0;
    public string $selectedName = '';
    public int $selectedPrice = 0;

    public bool $modalPenjualanDelete = false;

    #[Url(history: true, keep: true)]
    public $page = 1;
    public $perPage = 10;

    public $dateFilter;

    public function with(): array
    {
        $today = Carbon::today();
        $maxDate = $today->format('d-m-Y');
        $minDate = $today->copy()->subYears(5)->format('d-m-Y');

        $dateFrom = $minDate;
        $dateTo = $maxDate;
        if ($this->dateFilter) {
            $dateRange = explode(' to ', $this->dateFilter);
            $dateFrom = Carbon::createFromFormat('d-m-Y', $dateRange[0])->subDay();
            $dateTo = $dateFrom;
            if (count($dateRange) > 1) {
                $dateTo = Carbon::createFromFormat('d-m-Y', $dateRange[1]);
            }
        }

        return [
            'list_penjualan' => Penjualan::with('produk')
                ->whereBetween('tgl_pesanan', CarbonPeriod::create($dateFrom, $dateTo))
                ->orderBy('tgl_pesanan', 'desc')
                ->orderBy(
                    Produk::select('nama_produk')
                        ->whereColumn('produk_id', 'tb_penjualan.produk_id')
                        ->orderBy('nama_produk')
                        ->limit(1)
                )
                ->paginate($this->perPage),
            'headers' => [
                ['key' => 'no', 'label' => '#'],
                ['key' => 'tanggal_pesanan', 'label' => 'Tanggal Pesanan'],
                ['key' => 'produk.nama_produk', 'label' => 'Nama Produk'],
                ['key' => 'harga_jual', 'label' => 'Harga Jual', 'class' => 'text-right'],
                ['key' => 'qty', 'label' => 'Qty (pcs)', 'class' => 'text-right'],
                ['key' => 'total_harga', 'label' => 'Total Harga', 'class' => 'text-right'],
                ['key' => 'aksi', 'label' => 'Aksi', 'class' => 'text-center w-48'],
            ],
            'datepicker_config' => [
                'mode' => 'range',
                'altFormat' => 'd-m-Y',
                'dateFormat' => 'd-m-Y',
                'minDate' => $minDate,
                'maxDate' => $maxDate,
            ],
        ];
    }

    public function create(): void
    {
        redirect()->route('penjualan.create');
    }

    public function show($id): void
    {
        redirect()->route('penjualan.show', ['penjualan_id' => $id]);
    }

    public function edit($id): void
    {
        redirect()->route('penjualan.edit', ['penjualan_id' => $id]);
    }

    public function delete(): void
    {
        Penjualan::find($this->selectedId)->delete();
        redirect()->route('penjualan.index');
    }

    public function openModalPenjualanDelete($id, $name, $price): void
    {
        $this->modalPenjualanDelete = true;
        $this->selectedId = $id;
        $this->selectedName = $name;
        $this->selectedPrice = $price;
    }

    public function closeModalPenjualanDelete(): void
    {
        $this->modalPenjualanDelete = false;
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <h2 class="text-lg mb-4 font-medium text-gray-900 dark:text-gray-100">
            {{ __('Data Penjualan') }}
        </h2>

        <div class="flex gap-2">
            <x-mary-datepicker
                icon="o-calendar"
                :config="$datepicker_config"
                wire:model.live="dateFilter"
            />
            <x-mary-button
                icon="o-plus"
                label="Tambah Penjualan"
                wire:click="create"
            />
        </div>
    </header>

    <x-mary-table
        :headers="$headers"
        :rows="$list_penjualan"
        with-pagination
        per-page="perPage"
        :per-page-values="[10, 20, 50, 100]"
    >

        @scope('cell_no', $penjualan, $page, $perPage)
        {{ $loop->iteration + (($page - 1) * $perPage) }}
        @endscope

        @scope('cell_harga_jual', $penjualan)
        @uang($penjualan->harga_jual)
        @endscope

        @scope('cell_total_harga', $penjualan)
        @uang($penjualan->total_harga)
        @endscope

        @scope('cell_aksi', $penjualan)
        <div class="flex gap-2 justify-center">
            <x-mary-button
                spinner
                icon="o-eye"
                tooltip="Lihat"
                class="btn-sm btn-circle btn-ghost"
                wire:click="show({{ $penjualan->penjualan_id }})"
            />
            <x-mary-button
                spinner
                icon="o-pencil"
                tooltip="Ubah"
                class="btn-sm btn-circle btn-ghost"
                wire:click="edit({{ $penjualan->penjualan_id }})"
            />
            <x-mary-button
                spinner
                icon="o-trash"
                tooltip="Hapus"
                class="btn-sm btn-circle btn-ghost btn-error"
                wire:click="openModalPenjualanDelete({{ $penjualan->penjualan_id }}, '{{ $penjualan->produk->nama_produk }}', {{ $penjualan->total_harga }})"
            />
        </div>
        @endscope
    </x-mary-table>

    <x-mary-modal wire:model="modalPenjualanDelete" title="Hapus Penjualan">
        {{ __('Yakin ingin menghapus penjualan ') . __($selectedName) }}
        <b>@uang($selectedPrice)</b>
        <x-slot:actions>
            <x-mary-button
                label="{{ __('Batal') }}"
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
