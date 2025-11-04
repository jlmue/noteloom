<?php

namespace App\Livewire;

use App\Models\Note;
use App\Services\NoteSearchService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Displays paginated list of notes with search and sort
 *
 * Syncs search and sort with URL parameters
 */
class NotesList extends Component
{
    use WithPagination;

    /** Search text (synced with URL) */
    #[Url(as: 'search', keep: true)]
    public string $searchText = '';

    /** Sort option (synced with URL) */
    #[Url(as: 'sort', keep: true)]
    public string $sortBy = 'importance';

    /** Notes per page */
    protected int $perPage = 6;

    /**
     * Reset pagination when search changes
     */
    public function updatedSearchText(): void
    {
        $this->resetPage();
    }

    /**
     * Reset pagination when sort changes
     */
    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    /**
     * Update sort from NoteSort component event
     */
    #[On('sort-changed')]
    public function updateSort(string $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    /**
     * Delete note (ensures ownership)
     */
    public function delete(int $noteId): void
    {
        $note = Note::query()
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note->delete();

        $this->dispatch('notes-changed');
        session()->flash('success', 'Note deleted successfully!');
    }

    /**
     * Build search service with current filters
     */
    private function buildSearchService(): NoteSearchService
    {
        $service = new NoteSearchService;

        return $service
            ->forUser(Auth::user())
            ->search($this->searchText)
            ->sort($this->sortBy);
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        $searchService = $this->buildSearchService();

        // Get statistics BEFORE pagination to avoid any query state issues
        $stats = $searchService->getStatistics();

        // Now paginate
        $paginator = $searchService->paginate($this->perPage);

        return view('livewire.notes-list', [
            'notes' => $paginator->items(),
            'totalNotes' => $stats['total'],
            'filteredCount' => $stats['filtered'],
            'importantNotes' => $stats['important'],
            'hasSearch' => $stats['hasSearch'],
            'paginator' => $paginator,
        ]);
    }
}
