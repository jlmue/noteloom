@php
// ============================================================================
// SCROLL BEHAVIOR SETUP
// ============================================================================
// When pagination changes, scroll to this element (default: body)
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';

// ============================================================================
// PAGE RANGE CALCULATION
// ============================================================================
// Sliding window: show max 5 pages, keeping current page centered when possible
$currentPage = $paginator->currentPage();
$lastPage = $paginator->lastPage();
$maxPages = 5;
$half = (int) floor($maxPages / 2);

// Calculate start and end with automatic bounds checking
$startPage = max(1, min($currentPage - $half, $lastPage - $maxPages + 1));
$endPage = min($lastPage, $startPage + $maxPages - 1);
@endphp

<div>
    @if ($paginator->hasPages())
        <div class="px-3 py-3 md:px-4 md:py-4 border-t border-slate-200">

            {{-- ================================================================ --}}
            {{-- MOBILE VIEW: Compact Previous/Next with Page Indicator          --}}
            {{-- Visible only on small screens (< 768px)                         --}}
            {{-- ================================================================ --}}
            <div class="flex items-center justify-center gap-2 md:hidden">

                {{-- Previous Button (Mobile) --}}
                @if ($paginator->onFirstPage())
                    <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="ml-1.5">Prev</span>
                    </span>
                @else
                    <button
                        type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span class="ml-1.5">Prev</span>
                    </button>
                @endif

                {{-- Current Page Indicator (Mobile) --}}
                <span class="text-sm text-slate-600 font-medium px-2">
                    {{ $currentPage }}/{{ $lastPage }}
                </span>

                {{-- Next Button (Mobile) --}}
                @if ($paginator->hasMorePages())
                    <button
                        type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        x-on:click="{{ $scrollIntoViewJsSnippet }}"
                        wire:loading.attr="disabled"
                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        <span class="mr-1.5">Next</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                @else
                    <span class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed">
                        <span class="mr-1.5">Next</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                @endif
            </div>

            {{-- ================================================================ --}}
            {{-- DESKTOP VIEW: Full Pagination with Page Numbers                 --}}
            {{-- Visible only on medium+ screens (≥ 768px)                       --}}
            {{-- ================================================================ --}}
            <div class="hidden md:flex md:items-center md:justify-between">

                {{-- Results Summary (e.g., "Showing 1 to 6 of 42 results") --}}
                <div>
                    <p class="text-sm text-slate-600">
                        Showing
                        <span class="font-semibold text-slate-900">{{ $paginator->firstItem() ?? 0 }}</span>
                        to
                        <span class="font-semibold text-slate-900">{{ $paginator->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-semibold text-slate-900">{{ $paginator->total() }}</span>
                        results
                    </p>
                </div>

                {{-- Page Numbers Navigation --}}
                <div class="flex items-center space-x-1">

                    {{-- Previous Page Arrow Button --}}
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex items-center justify-center w-10 h-10 text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed" aria-label="Previous page (disabled)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </span>
                    @else
                        <button
                            type="button"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center w-10 h-10 text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                            aria-label="Previous page">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                    @endif

                    {{-- First Page + Ellipsis (if current window doesn't include page 1) --}}
                    @if ($startPage > 1)
                        {{-- Always show page 1 --}}
                        <button
                            type="button"
                            wire:click="gotoPage(1, '{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                            aria-label="Go to page 1">
                            1
                        </button>

                        {{-- Show ellipsis if there's a gap (e.g., page 1 ... page 5) --}}
                        @if ($startPage > 2)
                            <span class="inline-flex items-center justify-center w-10 h-10 text-slate-500" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </span>
                        @endif
                    @endif

                    {{-- Main Page Number Buttons (max 5) --}}
                    @for ($page = $startPage; $page <= $endPage; $page++)
                        @if ($page == $currentPage)
                            {{-- Current/Active Page --}}
                            <span class="inline-flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-md" aria-current="page">
                                {{ $page }}
                            </span>
                        @else
                            {{-- Other Pages --}}
                            <button
                                type="button"
                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                                aria-label="Go to page {{ $page }}">
                                {{ $page }}
                            </button>
                        @endif
                    @endfor

                    {{-- Last Page + Ellipsis (if current window doesn't include last page) --}}
                    @if ($endPage < $lastPage)
                        {{-- Show ellipsis if there's a gap (e.g., page 7 ... page 20) --}}
                        @if ($endPage < $lastPage - 1)
                            <span class="inline-flex items-center justify-center w-10 h-10 text-slate-500" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"/>
                                </svg>
                            </span>
                        @endif

                        {{-- Always show last page --}}
                        <button
                            type="button"
                            wire:click="gotoPage({{ $lastPage }}, '{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            class="inline-flex items-center justify-center w-10 h-10 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                            aria-label="Go to page {{ $lastPage }}">
                            {{ $lastPage }}
                        </button>
                    @endif

                    {{-- Next Page Arrow Button --}}
                    @if ($paginator->hasMorePages())
                        <button
                            type="button"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}"
                            wire:loading.attr="disabled"
                            class="inline-flex items-center justify-center w-10 h-10 text-blue-700 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-150 ease-in-out"
                            aria-label="Next page">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @else
                        <span class="inline-flex items-center justify-center w-10 h-10 text-slate-400 bg-slate-50 border border-slate-200 rounded-lg cursor-not-allowed" aria-label="Next page (disabled)">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
