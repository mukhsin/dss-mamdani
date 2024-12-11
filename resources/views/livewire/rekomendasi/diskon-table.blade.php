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

    public bool $showModal = false;

    public $headers = [
        ['key' => 'no', 'label' => '#'],
        ['key' => 'nama_produk', 'label' => 'Nama Produk'],
        ['key' => 'hasil_diskon', 'label' => 'Hasil Diskon (%)', 'class' => 'text-right'],
        ['key' => 'harga_modal', 'label' => 'Harga Modal', 'class' => 'text-right'],
        ['key' => 'harga_jual', 'label' => 'Harga Jual', 'class' => 'text-right'],
        ['key' => 'harga_setelah_diskon', 'label' => 'Harga Setelah Diskon', 'class' => 'text-right'],
        // ['key' => 'total_qty', 'label' => 'Qty', 'class' => 'text-right'],
        ['key' => 'keuntungan', 'label' => 'Keuntungan', 'class' => 'text-right'],
        ['key' => 'aksi', 'label' => 'Aksi', 'class' => 'text-center w-24'],
    ];
    public $list_produk;
    public string $modal_title = '';
    public array $list_step = [];
    public array $step_produk = [];

    public function mount($list_produk): void
    {
        $this->list_produk = $list_produk;
        $this->title = 'Hasil Perhitungan';
        // dd($this->list_produk);

        $list_step = [];
        foreach ($list_produk as $produk) {
            $list_step[$produk['produk_id']] = $produk['list_step'];
        }
        $this->list_step = $list_step;
    }

    public function openModalSteps($produk_id, $nama_produk): void
    {
        $this->showModal = true;
        $this->modal_title = $nama_produk;
        $this->step_produk = $this->list_step[$produk_id];
    }

    public function closeModalSteps(): void
    {
        $this->showModal = false;
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

        @scope('cell_no', $produk)
        {{ $loop->iteration }}
        @endscope

        @scope('cell_harga_modal', $produk)
        @uang($produk['harga_modal'])
        @endscope

        @scope('cell_harga_jual', $produk)
        @uang($produk['harga_jual'])
        @endscope

        @scope('cell_harga_setelah_diskon', $produk)
        @uang($produk['harga_setelah_diskon'])
        @endscope

        @scope('cell_keuntungan', $produk)
        @uang($produk['keuntungan'])
        @endscope

        @scope('cell_aksi', $produk)
        <div class="flex gap-2 justify-center">
            <x-mary-button
                spinner
                icon="o-calculator"
                class="btn-sm btn-circle btn-ghost"
                wire:click="openModalSteps({{ $produk['produk_id'] }}, '{{ $produk['nama_produk'] }}')"
            />
        </div>
        @endscope

    </x-mary-table>

    <x-mary-modal wire:model="showModal"
                  title="Perhitungan Diskon"
                  subtitle="{{ $modal_title }}"
                  box-class="max-w-6xl"
    >

        {{-- Fuzzyfikasi --}}
        <div class="py-4 border-t border-t-gray-300">
            <h2 class="font-bold text-2xl">Fuzzyfikasi</h2>
            <table class="table w-1/2">
                <tbody>
                @if( array_key_exists('input', $step_produk) )
                    <tr class="hover:bg-base-200/50">
                        <td>Harga Modal</td>
                        <td class="text-right">@uang( $step_produk['input']['harga_modal'] )</td>
                    </tr>
                    <tr class="hover:bg-base-200/50">
                        <td>Harga Jual</td>
                        <td class="text-right">@uang( $step_produk['input']['harga_jual'] )</td>
                    </tr>
                @endif
                </tbody>
            </table>

            @if( array_key_exists('parameters', $step_produk) )
                @foreach( $step_produk['parameters'] as $key => $parameter )
                    <div class="my-2 px-4">
                        <h2 class="font-bold text-lg">{{ $parameter['data']['nama'] }}</h2>
                        <div class="flex items-center">
                            <div class="flex-1">
                                <x-mary-chart wire:model="step_produk.parameters.{{ $key }}.chart"/>
                            </div>
                            <div class="flex-1">
                                @if( array_key_exists('myu', $parameter['data']) && count($parameter['data']['myu']) > 0 )
                                    <table class="table">
                                        <tbody>
                                        @foreach( $parameter['data']['myu'] as $myu )
                                            <tr class="hover:bg-base-200/50">
                                                <td>{{ $myu['nama'] }} [{{ $myu['param'] }}]</td>
                                                <td>{{ number_format($myu['index'], 2, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        {{-- Inferensi --}}
        <div class="py-4 border-t border-t-gray-300">
            <h2 class="font-bold text-2xl">Inferensi</h2>

            <div class="flex items-start my-6">
                <div class="">
                    <h2 class="font-bold text-lg px-4">Rules</h2>
                    <table class="table">
                        <tbody>
                        @if( array_key_exists('rules', $step_produk) && count($step_produk['rules']) > 0 )
                            @foreach( $step_produk['rules'] as $rule )
                                <tr class="hover:bg-base-200/50">
                                    <td>{{ $rule }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="">
                    <h2 class="font-bold text-lg px-4">Predicates</h2>
                    <table class="table">
                        <tbody>
                        @if( array_key_exists('predicates', $step_produk) && count($step_produk['predicates']) > 0 )
                            @foreach( $step_produk['predicates'] as $predicate )
                                <tr class="hover:bg-base-200/50">
                                    <td>{{ $predicate }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="">
                    <h2 class="font-bold text-lg px-4">Aggregates</h2>
                    <table class="table">
                        <tbody>
                        @if( array_key_exists('aggregates', $step_produk) && count($step_produk['aggregates']) > 0 )
                            @foreach( $step_produk['aggregates'] as $aggregate )
                                <tr class="hover:bg-base-200/50">
                                    <td>{{ $aggregate }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-start my-6">
                @if( array_key_exists('aggregate', $step_produk) )
                    <div class="flex-auto">
                        <h2 class="font-bold text-lg px-4">Menentukan nilai t1 dan t2</h2>
                        <table class="table">
                            <tbody>
                            @if( array_key_exists('t', $step_produk['aggregate'])
                            && count($step_produk['aggregate']['t']) > 0 )
                                @foreach( $step_produk['aggregate']['t'] as $key => $t )
                                    <tr class="hover:bg-base-200/50">
                                        <td>nilai t{{ ($key+1) }} = {{ number_format($t, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="flex-auto">
                        <h2 class="font-bold text-lg px-4">Himpunan fuzzy baru untuk DISKON</h2>
                        <x-mary-chart wire:model="step_produk.aggregate.chart"/>
                    </div>
                @endif
            </div>

        </div>

        {{-- Defuzzifikasi --}}
        <div class="py-4 border-t border-t-gray-300">
            <h2 class="font-bold text-2xl">Defuzzifikasi</h2>

            <div class="flex items-start my-6">
                <div class="flex-auto">
                    <h2 class="font-bold text-lg px-4">Menentukan momen</h2>
                    <table class="table">
                        <tbody>
                        @if( array_key_exists('moments', $step_produk) && count($step_produk['moments']) > 0 )
                            @foreach( $step_produk['moments'] as $key => $moment )
                                <tr class="hover:bg-base-200/50">
                                    <td>m{{ ($key+1) }} = {{ number_format($moment, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="flex-auto">
                    <h2 class="font-bold text-lg px-4">Menentukan area</h2>
                    <table class="table">
                        <tbody>
                        @if( array_key_exists('areas', $step_produk) && count($step_produk['areas']) > 0 )
                            @foreach( $step_produk['areas'] as $area )
                                <tr class="hover:bg-base-200/50">
                                    <td>m{{ ($key+1) }} = {{ number_format($area, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="flex-auto">
                    <h2 class="font-bold text-lg px-4">Menentukan centroid</h2>
                    <table class="table">
                        <tbody>
                        @if( array_key_exists('total_moments', $step_produk) && array_key_exists('total_areas', $step_produk) )
                            <tr class="hover:bg-base-200/50">
                                <td>total momen = {{ number_format($step_produk['total_moments'], 2, ',', '.') }}</td>
                            </tr>
                            <tr class="hover:bg-base-200/50">
                                <td>total area = {{ number_format($step_produk['total_areas'], 2, ',', '.') }}</td>
                            </tr>
                            <tr class="hover:bg-base-200/50">
                                <td>Z = (total momen) / (total area) = {{ number_format($step_produk['total_moments'] / $step_produk['total_areas'], 2, ',', '.') }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </x-mary-modal>

</section>
