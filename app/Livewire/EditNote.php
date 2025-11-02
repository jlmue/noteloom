<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditNote extends Component
{
    public Note $note;

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:10')]
    public string $content = '';

    public bool $is_important = false;

    public function mount(Note $note)
    {
        // Ensure the note belongs to the authenticated user
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $this->note = $note;
        $this->title = $note->title;
        $this->content = $note->content;
        $this->is_important = $note->is_important;
    }

    public function update()
    {
        $this->validate();

        $this->note->update([
            'title' => $this->title,
            'content' => $this->content,
            'is_important' => $this->is_important,
        ]);

        session()->flash('success', 'Note updated successfully!');

        return redirect()->route('dashboard');
    }

    public function cancel()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.edit-note');
    }
}
