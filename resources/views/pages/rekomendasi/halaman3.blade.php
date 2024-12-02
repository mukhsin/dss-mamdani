<?php

use App\Models\Rekomendasi;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Rekomendasi $rekomendasi;

    public function mount($rekomendasi_id): void
    {
        $this->rekomendasi = Rekomendasi::find($rekomendasi_id);
    }

};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:rekomendasi.diskon-table :rekomendasi="$rekomendasi"/>
        </div>
    </div>
</div>
