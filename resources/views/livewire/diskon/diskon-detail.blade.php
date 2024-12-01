<?php

use App\Models\Diskon;
use Livewire\Volt\Component;

new class extends Component {

    public Diskon $diskon;

    public bool $modalDiskonDelete = false;

    public function mount(Diskon $diskon): void
    {
        $this->diskon = $diskon;
    }

    public function back(): void
    {
        redirect()->route('diskon.index');
    }

    public function edit(): void
    {
        redirect()->route('diskon.edit', ['diskon_id' => $this->diskon->diskon_id]);
    }

    public function delete(): void
    {
        $this->diskon->delete();
        redirect()->route('diskon.index');
    }

    public function openModalDiskonDelete(): void
    {
        $this->modalDiskonDelete = true;
    }

    public function closeModalDiskonDelete(): void
    {
        $this->modalDiskonDelete = false;
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
                {{ __('Detail Diskon') }}
            </h2>
        </div>

        <div class="flex gap-2">
            <x-mary-button
                spinner
                icon="o-pencil"
                label="Ubah"
                wire:click="edit({{ $diskon->diskon_id }})"
            />
            <x-mary-button
                spinner
                icon="o-trash"
                label="Hapus"
                class="btn-error"
                wire:click="openModalDiskonDelete()"
            />
        </div>
    </header>

    <table class="table">
        <tbody>
        <tr class="hover:bg-base-200/50">
            <td>Jenis Diskon</td>
            <td>{{ $diskon->jenis_diskon }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Keterangan</td>
            <td>{{ $diskon->keterangan }}</td>
        </tr>
        <tr class="hover:bg-base-200/50">
            <td>Besaran Diskon (%)</td>
            <td>{{ $diskon->besaran_diskon }}</td>
        </tr>
        </tbody>
    </table>

    <x-mary-modal wire:model="modalDiskonDelete" title="Hapus Diskon">
        {{ __('Yakin ingin menghapus diskon ' . __($diskon->besaran_diskon.'% ') . __($diskon->jenis_diskon) . '?') }}
        <x-slot:actions>
            <x-mary-button
                label="Batal"
                wire:click="closeModalDiskonDelete()"
            />
            <x-mary-button
                spinner="delete"
                label="Hapus"
                class="btn-error"
                wire:click="delete()"
            />
        </x-slot:actions>
    </x-mary-modal>

</section>
