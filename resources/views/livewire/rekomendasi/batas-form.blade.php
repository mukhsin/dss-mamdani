<?php

use App\Models\Batas;
use App\Models\Rekomendasi;
use Livewire\Volt\Component;

new class extends Component {

    public string $title;

    public Batas $batas;
    public $batas_kecil_modal;
    // public $batas_sedang_modal;
    public $batas_besar_modal;
    public $batas_kecil_keuntungan;
    // public $batas_sedang_keuntungan;
    public $batas_besar_keuntungan;
    public $batas_kecil_diskon;
    // public $batas_sedang_diskon;
    public $batas_besar_diskon;

    public function mount(Batas $batas): void
    {
        // dd($batas);
        $this->batas = $batas;
        $this->title = 'Tambah Batas';

        if ($this->batas->batas_id) {
            $this->title = 'Ubah Batas';
            $this->batas_kecil_modal = $batas->batas_kecil_modal;
            // $this->batas_sedang_modal = $batas->batas_sedang_modal;
            $this->batas_besar_modal = $batas->batas_besar_modal;
            $this->batas_kecil_keuntungan = $batas->batas_kecil_keuntungan;
            // $this->batas_sedang_keuntungan = $batas->batas_sedang_keuntungan;
            $this->batas_besar_keuntungan = $batas->batas_besar_keuntungan;
            $this->batas_kecil_diskon = $batas->batas_kecil_diskon;
            // $this->batas_sedang_diskon = $batas->batas_sedang_diskon;
            $this->batas_besar_diskon = $batas->batas_besar_diskon;
        }
    }

    public function next(): void
    {
        $validated = $this->validate([
            'batas_kecil_modal' => ['required', 'numeric'],
            // 'batas_sedang_modal' => ['required', 'numeric'],
            'batas_besar_modal' => ['required', 'numeric'],
            'batas_kecil_keuntungan' => ['required', 'numeric'],
            // 'batas_sedang_keuntungan' => ['required', 'numeric'],
            'batas_besar_keuntungan' => ['required', 'numeric'],
            'batas_kecil_diskon' => ['required', 'numeric'],
            // 'batas_sedang_diskon' => ['required', 'numeric'],
            'batas_besar_diskon' => ['required', 'numeric'],
        ]);

        $this->batas->halaman = 1;
        $this->batas->batas_kecil_modal = $validated['batas_kecil_modal'];
        $this->batas->batas_sedang_modal = $validated['batas_kecil_modal'];
        $this->batas->batas_besar_modal = $validated['batas_besar_modal'];
        $this->batas->batas_kecil_keuntungan = $validated['batas_kecil_keuntungan'];
        $this->batas->batas_sedang_keuntungan = $validated['batas_kecil_keuntungan'];
        $this->batas->batas_besar_keuntungan = $validated['batas_besar_keuntungan'];
        $this->batas->batas_kecil_diskon = $validated['batas_kecil_diskon'];
        $this->batas->batas_sedang_diskon = $validated['batas_kecil_diskon'];
        $this->batas->batas_besar_diskon = $validated['batas_besar_diskon'];
        $this->batas->save();

        $rekomendasi = new Rekomendasi();
        $list_rekomendasi = Rekomendasi::where('batas_id', '=', $this->batas->batas_id)
            ->latest()
            ->get();

        if (count($list_rekomendasi) > 0) {
            $rekomendasi = $list_rekomendasi->first();
            Rekomendasi::where('batas_id', '=', $this->batas->batas_id)
                ->where('rekomendasi_id', '!=', $rekomendasi->rekomendasi_id)
                ->delete();
        } else {
            $rekomendasi = Rekomendasi::create([
                'batas_id' => $this->batas->batas_id,
            ]);
        }

        redirect()->route('rekomendasi.halaman2', ['rekomendasi_id' => $rekomendasi->rekomendasi_id]);
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

    <x-mary-form wire:submit="next" class="px-4" no-separator>
        <div class="flex flex-row gap-4 items-center sm:hidden">
            {{-- <div class="flex-1 flex flex-col gap-4"> --}}
            {{--     <x-mary-input label="{{ __('Batas Kecil Modal') }}" wire:model="batas_kecil_modal'," prefix="Rp"/> --}}
            {{--     <x-mary-input label="{{ __('Batas Sedang Modal') }}" wire:model="batas_sedang_modal'," prefix="Rp"/> --}}
            {{--     <x-mary-input label="{{ __('Batas Besar Modal') }}" wire:model="batas_besar_modal'," prefix="Rp"/> --}}
            {{-- </div> --}}
            {{-- <div class="flex-1 flex flex-col gap-4"> --}}
            {{--     <x-mary-input label="{{ __('Batas Kecil Keuntungan') }}" wire:model="batas_kecil_keuntungan'," prefix="Rp"/> --}}
            {{--     <x-mary-input label="{{ __('Batas Sedang Keuntungan') }}" wire:model="batas_sedang_keuntungan'," prefix="Rp"/> --}}
            {{--     <x-mary-input label="{{ __('Batas Besar Keuntungan') }}" wire:model="batas_besar_keuntungan'," prefix="Rp"/> --}}
            {{-- </div> --}}
            {{-- <div class="flex-1 flex flex-col gap-4"> --}}
            {{--     <x-mary-input label="{{ __('Batas Kecil Diskon') }}" wire:model="batas_kecil_diskon'," prefix="Rp"/> --}}
            {{--     <x-mary-input label="{{ __('Batas Sedang Diskon') }}" wire:model="batas_sedang_diskon'," prefix="Rp"/> --}}
            {{--     <x-mary-input label="{{ __('Batas Besar Diskon') }}" wire:model="batas_besar_diskon'," prefix="Rp"/> --}}
            {{-- </div> --}}
        </div>

        <div class="flex flex-col gap-8">
            <div class="flex-1 flex flex-col gap-4">
                <h3 class="text-xl font-bold">Input</h3>
                <div class="flex flex-col gap-2 w-1/2">
                    <x-mary-input label="{{ __('Batas Kecil Modal') }}" wire:model="batas_kecil_modal" prefix="Rp"/>
                    {{-- <x-mary-input label="{{ __('Batas Sedang Modal') }}" wire:model="batas_sedang_modal" prefix="Rp"/> --}}
                    <x-mary-input label="{{ __('Batas Besar Modal') }}" wire:model="batas_besar_modal" prefix="Rp"/>
                    <x-mary-input label="{{ __('Batas Kecil Keuntungan') }}" wire:model="batas_kecil_keuntungan" prefix="Rp"/>
                    {{-- <x-mary-input label="{{ __('Batas Sedang Keuntungan') }}" wire:model="batas_sedang_keuntungan" prefix="Rp"/> --}}
                     <x-mary-input label="{{ __('Batas Besar Keuntungan') }}" wire:model="batas_besar_keuntungan" prefix="Rp"/>
                </div>
            </div>
            <div class="flex-1 flex flex-col gap-4">
                <h3 class="text-xl font-bold">Output</h3>
                <div class="flex flex-col gap-2 w-1/2">
                    <x-mary-input label="{{ __('Batas Kecil Diskon') }}" wire:model="batas_kecil_diskon" prefix="%"/>
                    {{-- <x-mary-input label="{{ __('Batas Sedang Diskon') }}" wire:model="batas_sedang_diskon" prefix="%"/> --}}
                    <x-mary-input label="{{ __('Batas Besar Diskon') }}" wire:model="batas_besar_diskon" prefix="%"/>
                </div>
            </div>
        </div>

        <div class="flex gap-2 pt-4">
            <x-mary-button label="{{ __('Berikutnya') }}" class="btn-primary" type="submit" spinner="next"/>
        </div>
    </x-mary-form>

</section>
