<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Dashboard Component
 *
 * Displays statistics about user's notes including:
 * - Total notes count
 * - Important notes count
 * - Last updated timestamp
 *
 * Event Listeners:
 * - 'notes-changed': Refreshes dashboard when notes are created, updated, or deleted
 */
class Dashboard extends Component
{
    /**
     * Listen for notes changes and refresh dashboard statistics
     * Triggered when notes are created, updated, or deleted
     */
    #[On('notes-changed')]
    public function refreshStats(): void
    {
        // Livewire automatically re-renders the component
        // No need to manually update properties - render() will be called
    }

    /**
     * Render the dashboard with fresh statistics
     */
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        // Fetch all notes for statistics
        // Using get() instead of paginate since we need all notes for counts
        $notes = Note::query()
            ->where('user_id', Auth::id())
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('livewire.dashboard', [
            'totalNotes' => $notes->count(),
            'importantNotes' => $notes->where('is_important', true)->count(),
            'lastUpdated' => $notes->first()?->updated_at?->diffForHumans() ?? 'No notes yet',
        ]);
    }
}
