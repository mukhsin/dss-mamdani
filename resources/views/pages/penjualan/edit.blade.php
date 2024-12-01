<?php

use App\Models\Penjualan;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Penjualan $penjualan;

    public function mount($penjualan_id): void
    {
        $this->penjualan = Penjualan::with('produk')->find($penjualan_id);
    }

};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:penjualan.penjualan-form :penjualan="$penjualan"/>
        </div>
    </div>
</div>
