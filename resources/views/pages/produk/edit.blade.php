<?php

use App\Models\Produk;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Produk $produk;

    public function mount($produk_id): void
    {
        $this->produk = Produk::find($produk_id);
    }

};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:produk.produk-form :produk="$produk"/>
        </div>
    </div>
</div>
