<div class="relative">
    {{-- Search Input Container --}}
    <div class="relative flex items-center">
        {{-- Search Icon --}}
        <div class="absolute left-3 pointer-events-none">
            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>

        {{-- Search Input --}}
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

        {{-- Clear Button (visible when search has text) --}}
        @if ($searchText !== '')
            <button
                type="button"
                wire:click="clearSearch"
                class="absolute right-3 p-1 rounded-full
                       text-slate-400 hover:text-slate-600 hover:bg-slate-100
                       focus:outline-none focus:ring-2 focus:ring-blue-500
                       transition-all duration-150 ease-in-out"
                aria-label="Clear search"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif
    </div>

    {{-- Loading Indicator (shows during server updates) --}}
    <div wire:loading wire:target="searchText" class="absolute right-3 top-1/2 -translate-y-1/2">
        <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>
