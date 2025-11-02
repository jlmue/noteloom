<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class NotesList extends Component
{
    public function delete($noteId): void
    {
        $note = Note::query()
            ->where('id', $noteId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note->delete();

        session()->flash('success', 'Note deleted successfully!');
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        $notes = Note::query()
            ->where('user_id', Auth::id())
            ->orderBy('is_important', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('livewire.notes-list', [
            'notes' => $notes,
            'totalNotes' => $notes->count(),
            'importantNotes' => $notes->where('is_important', true)->count(),
        ]);
    }
}
