<?php

use App\Models\Penjualan;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Penjualan $penjualan;

    public function mount(): void
    {
        $this->penjualan = new Penjualan();
    }

};

?>

<div class="py-4">
    <div class="max-w-7xl mx-auto space-y-4">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:penjualan.penjualan-form :penjualan="$penjualan"/>
        </div>
    </div>
</div>