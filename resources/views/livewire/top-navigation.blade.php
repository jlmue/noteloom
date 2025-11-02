<header class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Brand Logo and Name --}}
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 hover:opacity-80 transition">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-slate-900">NoteLoom</h1>
            </a>

            {{-- User Info and Logout --}}
            <div class="flex items-center space-x-2 sm:space-x-4">
                {{-- User Avatar --}}
                <div class="hidden sm:flex items-center space-x-3">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gradient-to-br border-2 border-slate-800 avatar">
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
                    wire:target="logout"
                >
                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </div>
        </div>
    </div>
    <style lang="scss">
        .avatar {
            background-image: url('/images/avatar.png');
            background-size: cover;
        }
    </style>
</header>

