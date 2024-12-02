<?php

use App\Models\Rekomendasi;
use Illuminate\Support\Carbon;
use Livewire\Volt\Component;

new class extends Component {

    public string $title;

    public Rekomendasi $rekomendasi;

    public $tgl_awal;
    public $tgl_akhir;
    public $tgl_rentang;
    public $datepicker_config;

    public function mount(Rekomendasi $rekomendasi): void
    {
        $this->rekomendasi = $rekomendasi;
        $this->title = 'Tambah Rekomendasi';

        if ($this->rekomendasi->rekomendasi_id) {
            $this->title = 'Ubah Rekomendasi';
        }

        $this->constructDatepickerConfig();
        $this->constructTglRentang();
    }

    private function constructDatepickerConfig(): void
    {
        $today = Carbon::today();
        $maxDate = $today->format('d-m-Y');
        $minDate = $today->copy()->subYears(5)->format('d-m-Y');

        $this->datepicker_config = [
            'mode' => 'range',
            'altFormat' => 'd-m-Y',
            'dateFormat' => 'd-m-Y',
            'minDate' => $minDate,
            'maxDate' => $maxDate,
        ];
    }

    private function constructTglRentang(): void
    {
        if ($this->rekomendasi->rekomendasi_id) {
            $this->tgl_awal = Carbon::createFromFormat('Y-m-d', $this->rekomendasi->tgl_awal)->format('d-m-Y');
            $this->tgl_akhir = Carbon::createFromFormat('Y-m-d', $this->rekomendasi->tgl_akhir)->format('d-m-Y');
            $this->tgl_rentang = $this->tgl_awal . ' to ' . $this->tgl_akhir;
        }
    }

    public function updated($name, $value): void
    {
        if ($name == 'tgl_rentang') {
            $dateFrom = '';
            $dateTo = '';
            if ($value) {
                $dateRange = explode(' to ', $value);
                $dateFrom = Carbon::createFromFormat('d-m-Y', $dateRange[0]);
                $dateTo = $dateFrom;
                if (count($dateRange) > 1) {
                    $dateTo = Carbon::createFromFormat('d-m-Y', $dateRange[1]);
                }
            }

            $this->tgl_awal = $dateFrom->format('d-m-Y');
            $this->tgl_akhir = $dateTo->format('d-m-Y');
        }
    }

    public function next(): void
    {
        $validated = $this->validate([
            'tgl_awal' => ['required', 'date_format:d-m-Y'],
            'tgl_akhir' => ['required', 'date_format:d-m-Y'],
        ]);

        $this->rekomendasi->tgl_awal = Carbon::createFromFormat('d-m-Y', $validated['tgl_awal']);
        $this->rekomendasi->tgl_akhir = Carbon::createFromFormat('d-m-Y', $validated['tgl_akhir']);
        $this->rekomendasi->save();

        $batas = $this->rekomendasi->batas;
        $batas->halaman = 2;
        $batas->save();

        redirect()->route('rekomendasi.halaman3', ['rekomendasi_id' => $this->rekomendasi->rekomendasi_id]);
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <div class="flex items-center gap-2 px-4">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __( $title ) }}
                {{--                {{ $tgl_awal }}--}}
                {{--                {{ $tgl_akhir }}--}}
            </h2>
        </div>
    </header>

    <x-mary-form wire:submit="next" class="px-4" no-separator>
        <div class="w-1/2">
            <input type="hidden" class="hidden" wire:model.live="tgl_awal">
            <input type="hidden" class="hidden" wire:model.live="tgl_akhir">
            <x-mary-datepicker
                label="{{ __('Pilih Rentang Tanggal') }}"
                icon="o-calendar"
                :config="$datepicker_config"
                wire:model.live="tgl_rentang"
            />
        </div>

        <div class="flex gap-2 pt-4">
            <x-mary-button label="{{ __('Berikutnya') }}" class="btn-primary" type="submit" spinner="next"/>
        </div>
    </x-mary-form>

</section>
