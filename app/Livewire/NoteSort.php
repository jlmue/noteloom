<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

/**
 * Sort selector component (dispatches to parent)
 */
class NoteSort extends Component
{
    /** Current sort option from parent (reactive) */
    #[Reactive]
    public string $currentSort = 'importance';

    /**
     * Dispatch sort change to parent component
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
