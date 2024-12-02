<?php

use App\Models\Diskon;
use Livewire\Volt\Component;

new class extends Component {

    public string $title;

    public Diskon $diskon;
    public $jenis_diskon;
    public $besaran_diskon;
    public $keterangan;

    public function mount(Diskon $diskon): void
    {
        $this->diskon = $diskon;
        $this->title = 'Tambah Diskon';

        if ($this->diskon->diskon_id) {
            $this->title = 'Ubah Diskon';
            $this->jenis_diskon = $diskon->jenis_diskon;
            $this->besaran_diskon = $diskon->besaran_diskon;
            $this->keterangan = $diskon->keterangan;
        }
    }

    public function back(): void
    {
        if ($this->diskon->diskon_id) {
            redirect()->route('diskon.show', ['diskon_id' => $this->diskon->diskon_id]);
        } else {
            redirect()->route('diskon.index');
        }
    }

    public function save(): void
    {
        $validated = $this->validate([
            'jenis_diskon' => ['required', 'string', 'max:255'],
            'besaran_diskon' => ['required', 'integer', 'between:1,100'],
            'keterangan' => ['string', 'max:255'],
        ]);

        $this->diskon->jenis_diskon = $this->jenis_diskon;
        $this->diskon->besaran_diskon = $this->besaran_diskon;
        $this->diskon->keterangan = $this->keterangan;
        $this->diskon->save();

        redirect()->route('diskon.show', ['diskon_id' => $this->diskon->diskon_id]);
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <div class="flex items-center gap-2">
            <x-mary-button
                icon="o-chevron-left"
                class="btn-circle btn-ghost"
                wire:click="back()"
            />
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __( $title ) }}
            </h2>
        </div>
    </header>

    <x-mary-form wire:submit="save" class="px-4" no-separator>
        <x-mary-input label="{{ __('Jenis Diskon') }}" wire:model="jenis_diskon"/>
        <x-mary-input label="{{ __('Besaran Diskon') }}" wire:model="besaran_diskon" suffix="%"/>
        <x-mary-textarea
            label="{{ __('Keterangan') }}"
             wire:model="keterangan"
             rows="2"
         />

         <div class="flex gap-2">
             <x-mary-button label="{{ __('Simpan') }}" class="btn-primary" type="submit" spinner="save"/>
             <x-mary-button label="{{ __('Batal') }}" wire:click="back()"/>
         </div>
     </x-mary-form>

</section>
