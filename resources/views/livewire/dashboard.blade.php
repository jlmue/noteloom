<div class="min-h-screen bg-gradient-to-br from-slate-50 to-slate-100">
    {{-- Header / Navigation --}}
    <header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Brand Logo and Name --}}
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900">SwiftNote</h1>
                </div>

                {{-- User Info and Logout --}}
                <div class="flex items-center space-x-2 sm:space-x-4">
                    {{-- User Avatar --}}
                    <div class="hidden sm:flex items-center space-x-3">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 border-2 border-blue-300">
                            <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <span class="text-sm font-medium text-slate-700">{{ Auth::user()->name ?? Auth::user()->email }}</span>
                    </div>

                    {{-- Logout Button --}}
                    <button
                        wire:click="logout"
                        class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2 rounded-lg text-sm font-medium
                               text-slate-700 hover:text-slate-900
                               bg-slate-100 hover:bg-slate-200
                               border border-slate-300
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               transition duration-150 ease-in-out"
                        wire:loading.attr="disabled"
                    >
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="max-w-7xl mx-auto px-4 py-6 sm:px-6 lg:px-8">
        {{-- Welcome Section --}}
        <div class="mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">
                Welcome back{{ Auth::user()->name ? ', ' . explode(' ', Auth::user()->name)[0] : '' }}!
            </h2>
            <p class="text-slate-600">Manage your notes and stay organized with SwiftNote.</p>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
            {{-- Total Notes --}}
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Total Notes</p>
                        <p class="text-3xl font-bold text-slate-900">0</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Important Notes --}}
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Important</p>
                        <p class="text-3xl font-bold text-slate-900">0</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50">
                        <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Recent Activity --}}
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 p-6 hover:shadow-lg transition-shadow duration-200 sm:col-span-2 lg:col-span-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 mb-1">Last Updated</p>
                        <p class="text-lg font-semibold text-slate-900">No notes yet</p>
                    </div>
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-green-50">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Empty State / Notes Area --}}
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

            {{-- Empty State --}}
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
    </main>

    {{-- Footer --}}
    <livewire:footer />
</div>
