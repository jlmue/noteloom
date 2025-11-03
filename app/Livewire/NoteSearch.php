<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;

/**
 * NoteSearch Component
 *
 * Provides search input UI that syncs with parent NotesList component.
 * Uses Livewire's wire:model to bind directly to parent's searchText property,
 * which automatically updates the URL parameter ?search=query.
 *
 * No events needed - data flows directly through property binding.
 */
class NoteSearch extends Component
{
    /**
     * Render the search component
     */
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.note-search');
    }
}
