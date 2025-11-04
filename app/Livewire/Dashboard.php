<?php

namespace App\Livewire;

use App\Services\NoteSearchService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

/**
 * Dashboard component displaying user note statistics
 *
 * Listens to 'notes-changed' event to refresh stats
 */
class Dashboard extends Component
{
    /**
     * Refresh dashboard when notes change
     */
    #[On('notes-changed')]
    public function refreshStats(): void
    {
        // Livewire automatically re-renders
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        $searchService = (new NoteSearchService)
            ->forUser(Auth::user())
            ->sort('newest');

        $stats = $searchService->getStatistics();
        $latestNote = $searchService->first();

        return view('livewire.dashboard', [
            'totalNotes' => $stats['total'],
            'importantNotes' => $stats['important'],
            'lastUpdated' => $latestNote?->updated_at?->diffForHumans() ?? 'No notes yet',
        ]);
    }
}
