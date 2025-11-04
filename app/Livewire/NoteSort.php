<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class NoteSort extends Component
{
    /**
     * Current sort option passed from parent component
     * Used to display active state in UI
     * Reactive attribute ensures this updates when parent's sortBy changes
     */
    #[Reactive]
    public string $currentSort = 'importance';

    /**
     * Update sort option and dispatch event to NotesList
     * NotesList will update its URL-synced sortBy property
     */
    public function updateSort(string $sortOption): void
    {
        $this->dispatch('sort-changed', sortBy: $sortOption);
    }

    public function render()
    {
        return view('livewire.note-sort');
    }
}
