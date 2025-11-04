<?php

namespace App\Livewire;

use App\Services\NoteSearchService;
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
 * Architecture:
 * Uses NoteSearchService for all data retrieval, ensuring consistent
 * query logic across the application.
 *
 * Event Listeners:
 * - 'notes-changed': Refreshes dashboard when notes are created, updated, or deleted
 *
 * @see \App\Services\NoteSearchService For query building logic
 */
class Dashboard extends Component
{
    /**
     * Listen for notes changes and refresh dashboard statistics
     *
     * Triggered when notes are created, updated, or deleted.
     * Livewire automatically re-renders the component, so no manual
     * property updates are needed - render() will be called.
     */
    #[On('notes-changed')]
    public function refreshStats(): void
    {
        // Livewire automatically re-renders the component
        // No need to manually update properties - render() will be called
    }

    /**
     * Render the dashboard with fresh statistics
     *
     * Uses NoteSearchService to fetch statistics efficiently.
     * The service handles all query logic, keeping this component thin.
     *
     * @return Factory|\Illuminate\Contracts\View\View|View The rendered view
     */
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        // Initialize search service for the current user
        $searchService = (new NoteSearchService)
            ->forUser(Auth::user())
            ->sort('newest'); // Get most recent note for "last updated"

        // Get statistics efficiently
        $stats = $searchService->getStatistics();

        // Get the most recently updated note for timestamp display
        $latestNote = $searchService->first();

        return view('livewire.dashboard', [
            'totalNotes' => $stats['total'],
            'importantNotes' => $stats['important'],
            'lastUpdated' => $latestNote?->updated_at?->diffForHumans() ?? 'No notes yet',
        ]);
    }
}
