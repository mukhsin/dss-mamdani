<?php

use App\Models\Batas;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Batas $batas;

    public function mount(): void
    {
        $this->batas = new Batas();

        $list_batas = Batas::whereIn('halaman', array(1, 2))
            ->orderBy('halaman', 'desc')
            ->latest()
            ->get();

        if (count($list_batas) > 0) {
            $batas = $list_batas->first();
            $this->batas = $batas;
            Batas::whereIn('halaman', array(1, 2))
                ->where('batas_id', '!=', $batas->batas_id)
                ->delete();
        }
    }

};

?>

<div class="py-4">
    <div class="max-w-7xl mx-auto space-y-4">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:rekomendasi.batas-form :batas="$batas"/>
        </div>
    </div>
</div>
