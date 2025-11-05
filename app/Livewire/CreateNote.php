<?php

namespace App\Livewire;

use App\Models\Note;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * Form component for creating new notes
 */
class CreateNote extends Component
{
    #[Validate('required|min:3|max:255')]
    public string $title = '';

    #[Validate('required|min:10')]
    public string $content = '';

    public bool $is_important = false;

    public ?string $returnUrl = null;

    /**
     * Capture the referer URL on mount
     */
    public function mount()
    {
        $this->returnUrl = request()->header('referer');
    }

    /**
     * Save new note and navigate back
     */
    public function save()
    {
        $this->validate();

        Note::query()
            ->create([
                'user_id' => Auth::id(),
                'title' => $this->title,
                'content' => $this->content,
                'is_important' => $this->is_important,
            ]);

        session()->flash('success', 'Note created successfully!');

        return $this->redirectToReferer();
    }

    /**
     * Cancel and navigate back
     */
    public function cancel()
    {
        return $this->redirectToReferer();
    }

    /**
     * Redirect to return URL or dashboard
     */
    private function redirectToReferer()
    {
        if ($this->returnUrl && str_contains($this->returnUrl, url('/'))) {
            return redirect()->to($this->returnUrl);
        }

        return redirect()->route('dashboard');
    }

    public function render(): Factory|\Illuminate\Contracts\View\View|View
    {
        return view('livewire.create-note');
    }
}
