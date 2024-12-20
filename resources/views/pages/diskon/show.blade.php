<?php

use App\Models\Diskon;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new
#[Layout('layouts.app')]
class extends Component {

    public Diskon $diskon;

    public function mount($diskon_id): void
    {
        $this->diskon = Diskon::find($diskon_id);
    }

};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
            <livewire:diskon.diskon-detail :diskon="$diskon"/>
        </div>
    </div>
</div>
