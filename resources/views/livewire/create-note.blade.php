<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    {{-- Header / Navigation --}}
    <livewire:top-navigation />

    {{-- Main Content --}}
    <main class="max-w-4xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 text-sm">
                <li>
                    <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-slate-900 transition">
                        Dashboard
                    </a>
                </li>
                <li class="text-slate-400">/</li>
                <li class="text-slate-900 font-medium">Create Note</li>
            </ol>
        </nav>

        {{-- Page Title --}}
        <div class="mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Create New Note</h2>
            <p class="text-slate-600">Add a new note to keep track of your thoughts and ideas.</p>
        </div>

        {{-- Create Note Form Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                <form wire:submit="save" class="space-y-6">
                    {{-- Title Field --}}
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-700 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            wire:model="title"
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 text-slate-900 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition duration-150 ease-in-out
                                   @error('title') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Enter note title..."
                            autofocus
                        >
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Content Field --}}
                    <div>
                        <label for="content" class="block text-sm font-medium text-slate-700 mb-2">
                            Content <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="content"
                            wire:model="content"
                            rows="8"
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 text-slate-900 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition duration-150 ease-in-out resize-y
                                   @error('content') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Write your note content here..."
                        ></textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Important Checkbox --}}
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                        <label class="flex items-start group cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="is_important"
                                class="mt-0.5 w-5 h-5 rounded border-slate-300 text-amber-500
                                       focus:ring-2 focus:ring-amber-500 focus:ring-offset-0
                                       transition duration-150 ease-in-out cursor-pointer"
                            >
                            <div class="ml-3">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-slate-900 group-hover:text-slate-700 transition">
                                        Mark as Important
                                    </span>
                                    <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                                <p class="mt-1 text-xs text-slate-600">
                                    Important notes will be highlighted in your dashboard
                                </p>
                            </div>
                        </label>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button
                            type="submit"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 rounded-lg font-medium text-white
                                   bg-gradient-to-r from-blue-500 to-blue-600
                                   hover:from-blue-600 hover:to-blue-700
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                                   shadow-lg hover:shadow-xl
                                   transform hover:-translate-y-0.5
                                   transition-all duration-150 ease-in-out
                                   disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" wire:loading.remove wire:target="save">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" wire:loading wire:target="save">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="save">Save Note</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>

                        <button
                            type="button"
                            wire:click="cancel"
                            class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 rounded-lg font-medium
                                   text-slate-700 hover:text-slate-900
                                   bg-slate-100 hover:bg-slate-200
                                   border border-slate-300
                                   focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2
                                   transition duration-150 ease-in-out"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Help Text --}}
        <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm text-blue-900">
                    <p class="font-medium mb-1">Tips for great notes:</p>
                    <ul class="list-disc list-inside space-y-1 text-blue-800">
                        <li>Use descriptive titles to easily find your notes later</li>
                        <li>Write at least 10 characters for meaningful content</li>
                        <li>Mark important notes to keep them highlighted</li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    {{-- Footer --}}
    <livewire:footer />
</div>
