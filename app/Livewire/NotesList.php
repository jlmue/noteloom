<?php

namespace App\Livewire;

use App\Models\Note;
use App\Services\NoteSearchService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * NotesList Component
 *
 * Displays user's notes with search, filtering, and pagination functionality.
 * Uses Livewire's WithPagination trait for seamless pagination handling.
 *
 * Search functionality uses URL parameters (?search=query) making searches
 * shareable and bookmarkable.
 *
 * Architecture:
 * This component follows the Thin Controller principle by delegating
 * all query logic to NoteSearchService. The component only handles:
 * - User input (search, sort)
 * - User actions (delete)
 * - View rendering
 *
 * @see NoteSearchService For query building logic
 */
class NotesList extends Component
{
    use WithPagination;

    /**
     * Search query for filtering notes by title or content
     * Synced with URL parameter ?search=query
     */
    #[Url(as: 'search')]
    public string $searchText = '';

    /**
     * Sort option for ordering notes
     * Synced with URL parameter ?sort=option
     * Options: 'importance', 'newest', 'oldest'
     */
    #[Url(as: 'sort')]
    public string $sortBy = 'importance';

    /**
     * Number of notes to display per page
     * Used by Livewire's pagination
     */
    protected int $perPage = 6;

    /**
     * Automatically called by Livewire when searchText changes
     * Resets pagination to page 1 when user performs a new search
     */
    public function updatedSearchText(): void
    {
        $this->resetPage();
    }

    /**
     * Automatically called by Livewire when sortBy changes (via URL parameter)
     * Resets pagination to page 1 when user changes sort option
     */
    public function updatedSortBy(): void
    {
        $this->resetPage();
    }

    /**
     * Listen for sort-changed event from NoteSort component
     * Update sortBy (which updates URL) and pagination is auto-reset via updatedSortBy()
     */
    #[On('sort-changed')]
    public function updateSort(string $sortBy): void
    {
        $this->sortBy = $sortBy;
    }

    /**
     * Delete a note by ID
     *
     * Security: Ensures the note belongs to the authenticated user
     * before deletion. Uses firstOrFail() to prevent unauthorized access.
     *
     * Side Effects:
     * - Dispatches 'notes-changed' event to refresh Dashboard statistics
     * - Sets success flash message for user feedback
     * - Livewire's pagination automatically handles page adjustment
     *
     * @param  int  $noteId  The ID of the note to delete
     *
     * @throws ModelNotFoundException If note not found or unauthorized
     */
    public function delete(int $noteId): void
    {
        $note = Note::query()
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note->delete();

        // Dispatch event to notify Dashboard component to refresh counts
        $this->dispatch('notes-changed');

        session()->flash('success', 'Note deleted successfully!');
    }

    /**
     * Build the search service with current filters applied
     *
     * This method creates a configured NoteSearchService instance
     * with all current filters (user, search, sort) applied.
     *
     * @return NoteSearchService Configured service instance
     */
    private function buildSearchService(): NoteSearchService
    {
        $service = new NoteSearchService;

        return $service
            ->forUser(Auth::user())
            ->search($this->searchText)
            ->sort($this->sortBy);
    }

    /**
     * Render the component with filtered and paginated notes
     *
     * Delegates all query logic to NoteSearchService, keeping this component
     * focused on presentation and user interaction.
     *
     * Livewire's WithPagination trait handles page state and URL parameters automatically.
     *
     * @return Factory|\Illuminate\Contracts\View\View|View The rendered view
     */
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        // Build the search service with current filters
        $searchService = $this->buildSearchService();

        // Get paginated results
        $paginator = $searchService->paginate($this->perPage);

        // Get statistics for display
        $stats = $searchService->getStatistics();

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
