<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Form component for editing existing notes
 */
class EditNote extends Component
{
    public Note $note;

    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:10')]
    public string $content = '';

    public bool $is_important = false;

    /**
     * Load note and verify ownership
     */
    public function mount(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $this->note = $note;
        $this->title = $note->title;
        $this->content = $note->content;
        $this->is_important = $note->is_important;
    }

    /**
     * Update note and redirect to dashboard
     */
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

    /**
     * Cancel and navigate back
     */
    public function cancel(): void
    {
        $this->js('window.history.back()');
    }

    public function render()
    {
        return view('livewire.edit-note');
    }
}
