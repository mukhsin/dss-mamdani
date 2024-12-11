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
        foreach ($list_produk as $data) {
            $harga_modal = $data->harga_modal;
            $harga_jual = $data->harga_jual;

            $total_qty = 0;
            foreach ($data->list_penjualan as $penjualan) {
                $total_qty += $penjualan->qty;
            }

            $mamdani = new Mamdani($harga_modal, $harga_jual * $total_qty, $parameters);
            $hasil_diskon = $mamdani->getResult();
            $data->hasil_diskon = number_format($hasil_diskon, 2, ',', '.');
            $data->list_step = $mamdani->getListStep();

            $harga_setelah_diskon = (100 - $hasil_diskon) / 100 * $harga_jual;
            $data->harga_setelah_diskon = ($harga_setelah_diskon);

            $keuntungan = $harga_setelah_diskon - $harga_modal;
            $data->keuntungan = ($keuntungan);
        }

        $this->list_produk = $list_produk->toArray();
        // dd($list_produk->toArray());

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
                (float)($batas->batas_besar_modal + $batas->batas_kecil_modal),
                (float)($batas->batas_besar_modal + $batas->batas_kecil_modal)),
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
                (float)($batas->batas_besar_keuntungan + $batas->batas_besar_keuntungan),
                (float)($batas->batas_besar_keuntungan + $batas->batas_besar_keuntungan)),
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
                (float)($batas->batas_besar_diskon + $batas->batas_kecil_diskon),
                (float)($batas->batas_besar_diskon + $batas->batas_kecil_diskon)),
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
