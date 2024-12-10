<?php

use App\Fuzzy\Himpunan;
use App\Fuzzy\Mamdani;
use App\Fuzzy\Variabel;
use App\Models\Produk;
use App\Models\Rekomendasi;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Rekomendasi $rekomendasi;

    public $list_produk;

    public function mount($rekomendasi_id): void
    {
        $this->rekomendasi = Rekomendasi::find($rekomendasi_id);

        $dateTo = $this->rekomendasi->tgl_akhir;
        $dateFrom = $this->rekomendasi->tgl_awal;
        $dateFrom = Carbon::parse($dateFrom)->subDay();
        $list_produk = Produk::with([
            'list_penjualan' => function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('tgl_pesanan', CarbonPeriod::create($dateFrom, $dateTo));
            }])
            ->whereHas('list_penjualan', function ($query) use ($dateFrom, $dateTo) {
                $query->whereBetween('tgl_pesanan', CarbonPeriod::create($dateFrom, $dateTo));
            })
            ->orderBy('nama_produk', 'asc')
            ->get();

        $parameters = $this->prepareParameters();

        // dd($list_produk->toArray());
        foreach ($list_produk as $data) {
            $harga_modal = $data->harga_modal;
            $total_harga = 0;
            $total_qty = 0;
            foreach ($data->list_penjualan as $penjualan) {
                $total_harga += $penjualan->total_harga;
                $total_qty += $penjualan->qty;
            }

            $mamdani = new Mamdani($harga_modal, $total_harga);
            $mamdani->prepareParameters($parameters);
            $hasil_diskon = $mamdani->getResult();
            $data->hasil_diskon = number_format($hasil_diskon, 2, ',', '.');

            // $harga_jual = $total_harga / $total_qty;
            // $data->harga_jual = ceil($harga_jual);
            $data->total_qty = ceil($total_qty);

            $harga_jual = $data->harga_jual;
            $harga_setelah_diskon = (100 - $hasil_diskon) / 100 * $harga_jual;
            $data->harga_setelah_diskon = ($harga_setelah_diskon);

            $keuntungan = $harga_setelah_diskon - $harga_modal;
            $data->keuntungan = ($keuntungan);
        }

        $this->list_produk = $list_produk;
        // dd($list_produk->toArray());

        // $mamdani = new Mamdani(35 * 1000, 12 * 1000 * 1000);
        // $mamdani->prepareParameters($parameters);
        // $diskonProduk = $mamdani->getResult();
        // dd($diskonProduk);

    }

    private function prepareParameters(): array
    {
        $batas = $this->rekomendasi->batas;
        $modal = new Variabel('modal', [
            new Himpunan('kecil',
                (float)(0.0),
                (float)(0.0),
                (float)($batas->batas_kecil_modal),
                (float)($batas->batas_besar_modal)),
            new Himpunan('besar',
                (float)($batas->batas_kecil_modal),
                (float)($batas->batas_besar_modal),
                (float)($batas->batas_besar_modal * 2),
                (float)($batas->batas_besar_modal * 2)),
        ]);
        $untung = new Variabel('untung', [
            new Himpunan('kecil',
                (float)(0.0),
                (float)(0.0),
                (float)($batas->batas_kecil_keuntungan),
                (float)($batas->batas_besar_keuntungan)),
            new Himpunan('besar',
                (float)($batas->batas_kecil_keuntungan),
                (float)($batas->batas_besar_keuntungan),
                (float)($batas->batas_besar_keuntungan * 2),
                (float)($batas->batas_besar_keuntungan * 2)),
        ]);
        $diskon = new Variabel('diskon', [
            new Himpunan('kecil',
                (float)(0.0),
                (float)(0.0),
                (float)($batas->batas_kecil_diskon),
                (float)($batas->batas_besar_diskon)),
            new Himpunan('besar',
                (float)($batas->batas_kecil_diskon),
                (float)($batas->batas_besar_diskon),
                (float)($batas->batas_besar_diskon * 2),
                (float)($batas->batas_besar_diskon * 2)),
        ]);

        return [
            'modal' => $modal,
            'untung' => $untung,
            'diskon' => $diskon,
        ];
    }

};

?>

<div class="py-4">
    <div class="max-w-7xl mx-auto space-y-4">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:rekomendasi.diskon-table
                :list_produk="$list_produk"
            />
        </div>
    </div>
</div>
