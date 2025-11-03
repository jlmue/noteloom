<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * NotesList Component
 *
 * Displays user's notes with search and pagination functionality.
 * Uses Livewire's WithPagination trait for seamless pagination handling.
 *
 * Search functionality uses URL parameters (?search=query) making searches
 * shareable and bookmarkable.
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
     * Livewire's pagination automatically handles page adjustment
     * Dispatches event to update dashboard widgets
     */
    public function delete($noteId): void
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
     * Build the base query for notes
     * Applies user filter and search if present
     */
    private function getNotesQuery(): Builder
    {
        $query = Note::query()
            ->where('user_id', Auth::id());

        // Apply search filter at database level for better performance
        if ($this->searchText !== '') {
            $searchTerm = '%'.$this->searchText.'%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', $searchTerm)
                    ->orWhere('content', 'like', $searchTerm);
            });
        }

        return $query;
    }

    /**
     * Get the total count of notes (without search filter)
     */
    private function getTotalNotesCount(): int
    {
        return Note::query()
            ->where('user_id', Auth::id())
            ->count();
    }

    /**
     * Apply sorting to the query based on selected sort option
     */
    private function applySorting(Builder $query): Builder
    {
        return match ($this->sortBy) {
            'newest' => $query->orderBy('created_at', 'desc'),
            'oldest' => $query->orderBy('created_at'),
            'importance' => $query->orderBy('is_important', 'desc')->orderBy('updated_at', 'desc'),
            default => $query->orderBy('is_important', 'desc')->orderBy('updated_at', 'desc'),
        };
    }

    /**
     * Render the component with filtered and paginated notes
     * Livewire's WithPagination trait handles page state and URL parameters automatically
     */
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        // Get total count of all user's notes (for display purposes)
        $totalNotes = $this->getTotalNotesCount();

        // Get paginated notes - Livewire automatically handles the page parameter from URL
        $query = $this->getNotesQuery();
        $query = $this->applySorting($query);
        $paginator = $query->paginate($this->perPage);

        // Count important notes in the filtered results
        $importantCount = $this->getNotesQuery()
            ->where('is_important', true)
            ->count();

        return view('livewire.notes-list', [
            'notes' => $paginator->items(),
            'totalNotes' => $totalNotes,
            'filteredCount' => $paginator->total(),
            'importantNotes' => $importantCount,
            'hasSearch' => $this->searchText !== '',
            'paginator' => $paginator,
        ]);
    }
}
