<?php

use App\Models\Diskon;
use Livewire\Attributes\Url;
use Livewire\Volt\Component;

new class extends Component {

    use \Livewire\WithPagination;

    public int $selectedId = 0;
    public string $selectedName = '';

    public bool $modalDiskonDelete = false;

    #[Url(history: true, keep: true)]
    public $page = 1;
    public $perPage = 10;

    public function with(): array
    {
        return [
            'list_diskon' => Diskon::paginate($this->perPage),
            'headers' => [
                ['key' => 'no', 'label' => '#'],
                ['key' => 'jenis_diskon', 'label' => 'Jenis Diskon'],
                ['key' => 'keterangan', 'label' => 'Keterangan'],
                ['key' => 'besaran_diskon', 'label' => 'Besaran Diskon (%)', 'class' => 'text-center'],
                ['key' => 'aksi', 'label' => 'Aksi', 'class' => 'text-center w-48'],
            ],
        ];
    }

    public function create(): void
    {
        redirect()->route('diskon.create');
    }

    public function show($id): void
    {
        redirect()->route('diskon.show', ['diskon_id' => $id]);
    }

    public function edit($id): void
    {
        redirect()->route('diskon.edit', ['diskon_id' => $id]);
    }

    public function delete(): void
    {
        Diskon::find($this->selectedId)->delete();
        redirect()->route('diskon.index');
    }

    public function openModalDiskonDelete($id, $name): void
    {
        $this->modalDiskonDelete = true;
        $this->selectedId = $id;
        $this->selectedName = $name;
    }

    public function closeModalDiskonDelete(): void
    {
        $this->modalDiskonDelete = false;
    }

};

?>

<section class="space-y-6">
    <header class="flex justify-between">
        <h2 class="text-lg mb-4 font-medium text-gray-900 dark:text-gray-100">
            {{ __('Data Diskon') }}
        </h2>
        <x-mary-button
            icon="o-plus"
            label="Tambah Diskon"
            wire:click="create"
        />
    </header>

    <x-mary-table
        :headers="$headers"
        :rows="$list_diskon"
        with-pagination
        per-page="perPage"
        :per-page-values="[10, 20, 50, 100]"
    >

        @scope('cell_no', $diskon, $page, $perPage)
        {{ $loop->iteration + (($page - 1) * $perPage) }}
        @endscope

        @scope('cell_aksi', $diskon)
        <div class="flex gap-2 justify-center">
            <x-mary-button
                spinner
                icon="o-eye"
                tooltip="Lihat"
                class="btn-sm btn-circle btn-ghost"
                wire:click="show({{ $diskon->diskon_id }})"
            />
            <x-mary-button
                spinner
                icon="o-pencil"
                tooltip="Ubah"
                class="btn-sm btn-circle btn-ghost"
                wire:click="edit({{ $diskon->diskon_id }})"
            />
            <x-mary-button
                spinner
                icon="o-trash"
                tooltip="Hapus"
                class="btn-sm btn-circle btn-ghost btn-error"
                wire:click="openModalDiskonDelete({{ $diskon->diskon_id }}, '{{ __($diskon->besaran_diskon.'% ') . __($diskon->jenis_diskon) }}')"
            />
        </div>
        @endscope
    </x-mary-table>

    <x-mary-modal wire:model="modalDiskonDelete" title="Hapus Diskon">
        {{ __('Yakin ingin menghapus diskon ' . $selectedName . '?') }}
        <x-slot:actions>
            <x-mary-button
                label="{{ __('Batal') }}"
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
