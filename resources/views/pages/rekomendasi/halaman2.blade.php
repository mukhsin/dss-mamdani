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

<div class="py-4">
    <div class="max-w-7xl mx-auto space-y-4">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:rekomendasi.tanggal-form :rekomendasi="$rekomendasi"/>
        </div>
    </div>
</div>
