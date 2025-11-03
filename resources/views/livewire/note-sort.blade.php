{{-- Sort Controls --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
    <span class="text-xs sm:text-sm text-slate-600 font-medium">Sort by:</span>
    <div class="flex gap-1 bg-slate-100 rounded-lg p-1 w-full sm:w-auto">
        <button
            wire:click="updateSort('importance')"
            class="flex-1 sm:flex-none px-2 sm:px-3 py-2 sm:py-1.5 text-xs sm:text-sm font-medium rounded-md transition-all duration-150
                   {{ $currentSort === 'importance' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
            title="Sort by importance"
        >
            <div class="flex items-center justify-center sm:justify-start gap-1 sm:gap-1.5">
                <svg class="w-4 h-4 flex-shrink-0 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <span class="hidden xs:inline sm:inline">Importance</span>
            </div>
        </button>

        <button
            wire:click="updateSort('newest')"
            class="flex-1 sm:flex-none px-2 sm:px-3 py-2 sm:py-1.5 text-xs sm:text-sm font-medium rounded-md transition-all duration-150
                   {{ $currentSort === 'newest' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
            title="Sort by newest first"
        >
            <div class="flex items-center justify-center sm:justify-start gap-1 sm:gap-1.5">
                <svg class="w-4 h-4 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="hidden xs:inline sm:inline">Newest</span>
            </div>
        </button>

        <button
            wire:click="updateSort('oldest')"
            class="flex-1 sm:flex-none px-2 sm:px-3 py-2 sm:py-1.5 text-xs sm:text-sm font-medium rounded-md transition-all duration-150
                   {{ $currentSort === 'oldest' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-600 hover:text-slate-900' }}"
            title="Sort by oldest first"
        >
            <div class="flex items-center justify-center sm:justify-start gap-1 sm:gap-1.5">
                <svg class="w-4 h-4 flex-shrink-0 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="hidden xs:inline sm:inline">Oldest</span>
            </div>
        </button>
    </div>
</div>
