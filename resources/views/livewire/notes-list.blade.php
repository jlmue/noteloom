<div>
    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center space-x-3">
                <svg class="w-5 h-5 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm font-medium text-green-900">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- Notes List or Empty State --}}
    @if ($totalNotes === 0)
        {{-- Empty State - No notes at all --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Your Notes</h3>
                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg font-medium text-white
                           bg-gradient-to-r from-blue-500 to-blue-600
                           hover:from-blue-600 hover:to-blue-700
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                           shadow-md hover:shadow-lg
                           transform hover:-translate-y-0.5
                           transition-all duration-150 ease-in-out">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Note
                </a>
            </div>

            <div class="px-6 py-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-100 mb-6">
                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-slate-900 mb-2">No notes yet</h3>
                <p class="text-slate-600 mb-6 max-w-md mx-auto">
                    Get started by creating your first note. Keep track of your thoughts, ideas, and important information.
                </p>
                <a href="{{ route('notes.create') }}" class="inline-flex items-center px-6 py-3 rounded-lg font-medium text-white
                           bg-gradient-to-r from-blue-500 to-blue-600
                           hover:from-blue-600 hover:to-blue-700
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                           shadow-lg hover:shadow-xl
                           transform hover:-translate-y-0.5
                           transition-all duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Your First Note
                </a>
            </div>
        </div>
    @else
        {{-- Notes Grid --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden mb-6">
            <div class="px-4 sm:px-6 py-4 border-b border-slate-200">
                {{-- Header Row --}}
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900">Your Notes</h3>
                        <p class="text-sm text-slate-600 mt-0.5">
                            @if ($hasSearch)
                                {{ $filteredCount }} of {{ $totalNotes }} {{ Str::plural('note', $totalNotes) }}
                            @else
                                {{ $totalNotes }} {{ Str::plural('note', $totalNotes) }}
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('notes.create') }}" class="inline-flex items-center px-3 sm:px-4 py-2 rounded-lg font-medium text-white
                               bg-gradient-to-r from-blue-500 to-blue-600
                               hover:from-blue-600 hover:to-blue-700
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               shadow-md hover:shadow-lg
                               transform hover:-translate-y-0.5
                               transition-all duration-150 ease-in-out
                               text-sm">
                        <svg class="w-4 h-4 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden sm:inline">New Note</span>
                        <span class="sm:hidden">New</span>
                    </a>
                </div>

                {{-- Search Input --}}
                <div class="relative">
                    {{-- Search Icon --}}
                    <div class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    {{-- Search Input Field --}}
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="searchText"
                        placeholder="Search notes by title or content..."
                        class="w-full pl-10 pr-10 py-2.5 rounded-lg border border-slate-300
                               text-slate-900 placeholder-slate-500
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               transition-all duration-150 ease-in-out
                               text-sm md:text-base"
                    >

                    {{-- Clear Button (shows when search has text) --}}
                    @if ($searchText !== '')
                        <button
                            type="button"
                            wire:click="$set('searchText', '')"
                            class="absolute right-3 top-1/2 -translate-y-1/2 p-1 rounded-full
                                   text-slate-400 hover:text-slate-600 hover:bg-slate-100
                                   focus:outline-none focus:ring-2 focus:ring-blue-500
                                   transition-all duration-150 ease-in-out"
                            aria-label="Clear search">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    @endif

                    {{-- Loading Indicator (shows during search) --}}
                    <div wire:loading wire:target="searchText" class="absolute right-3 top-1/2 -translate-y-1/2">
                        <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                {{-- Sort Controls --}}
                <div class="mt-4">
                    <livewire:note-sort :current-sort="$sortBy" />
                </div>
            </div>

            <div class="p-4 sm:p-6">
                {{-- No Search Results State --}}
                @if ($hasSearch && $filteredCount === 0)
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 mb-4">
                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-2">No notes found</h3>
                        <p class="text-slate-600 mb-4">
                            No notes match your search for "<span class="font-medium">{{ $searchText }}</span>"
                        </p>
                        <button
                            wire:click="$set('searchText', '')"
                            class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-medium
                                   text-blue-700 hover:text-blue-900
                                   bg-blue-50 hover:bg-blue-100
                                   border border-blue-200
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                   transition duration-150 ease-in-out">
                            Clear search
                        </button>
                    </div>
                @else
                    {{-- Notes Grid --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($notes as $note)
                        <div class="bg-white border-2 rounded-xl p-5 hover:shadow-lg transition-shadow duration-200
                                    {{ $note->is_important ? 'border-amber-300 bg-amber-50' : 'border-slate-200' }}">

                            {{-- Title --}}
                            <h4 class="flex items-center gap-1 mb-2">
                                @if ($note->is_important)
                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endif

                                <a href="{{ route('notes.edit', $note) }}" class="text-slate-900 hover:text-blue-500 text-lg font-semibold truncate block">
                                    {{ $note->title }}
                                </a>
                            </h4>

                            {{-- Content Preview --}}
                            <p class="text-sm text-slate-600 mb-4 text-ellipsis truncate ...">
                                {{ $note->content }}
                            </p>

                            {{-- Meta Info --}}
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500 mb-4">
                                {{-- Created At --}}
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span>{{ $note->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                {{-- Updated At --}}
                                <div class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span>{{ $note->updated_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('notes.edit', $note) }}"
                                   class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm font-medium
                                          text-blue-700 hover:text-blue-900
                                          bg-blue-50 hover:bg-blue-100
                                          border border-blue-200
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                          transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <button
                                    wire:click="delete({{ $note->id }})"
                                    wire:confirm="Are you sure you want to delete this note? This action cannot be undone."
                                    class="flex-1 inline-flex items-center justify-center px-3 py-2 rounded-lg text-sm font-medium
                                           text-red-700 hover:text-red-900
                                           bg-red-50 hover:bg-red-100
                                           border border-red-200
                                           focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2
                                           transition duration-150 ease-in-out">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Pagination Component --}}
            {{ $paginator->links('livewire::note-pagination') }}
        </div>
    @endif
</div>
