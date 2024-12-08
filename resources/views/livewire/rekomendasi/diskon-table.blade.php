<?php

use App\Fuzzy\Himpunan;
use App\Fuzzy\Variabel;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Rekomendasi;
use Carbon\CarbonPeriod;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {

    public string $title;

    public $headers = [
        ['key' => 'no', 'label' => '#'],
        ['key' => 'nama_produk', 'label' => 'Nama Produk'],
        ['key' => 'hasil_diskon', 'label' => 'Hasil Diskon (%)', 'class' => 'text-right'],
        ['key' => 'harga_modal', 'label' => 'Harga Modal', 'class' => 'text-right'],
        ['key' => 'harga_jual', 'label' => 'Harga Jual', 'class' => 'text-right'],
        ['key' => 'harga_setelah_diskon', 'label' => 'Harga Setelah Diskon', 'class' => 'text-right'],
        // ['key' => 'total_qty', 'label' => 'Qty', 'class' => 'text-right'],
        ['key' => 'keuntungan', 'label' => 'Keuntungan', 'class' => 'text-right'],
        // ['key' => 'aksi', 'label' => 'Aksi', 'class' => 'text-center w-48'],
    ];
    public $list_produk;

    public function mount($list_produk): void
    {
        $this->list_produk = $list_produk;
        $this->title = 'Hasil Perhitungan';

    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <div class="flex items-center gap-2 px-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __( $title ) }}
            </h2>
        </div>
    </header>

    <x-mary-table
        :headers="$headers"
        :rows="$list_produk"
    >

        @scope('cell_no', $penjualan)
        {{ $loop->iteration }}
        @endscope

        @scope('cell_harga_modal', $produk)
        @uang($produk->harga_modal)
        @endscope

        @scope('cell_harga_jual', $produk)
        @uang($produk->harga_jual)
        @endscope

        @scope('cell_harga_setelah_diskon', $produk)
        @uang($produk->harga_setelah_diskon)
        @endscope

        @scope('cell_keuntungan', $produk)
        @uang($produk->keuntungan)
        @endscope

    </x-mary-table>

</section>
