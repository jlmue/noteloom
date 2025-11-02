<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Dashboard extends Component
{
    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
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
