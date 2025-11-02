<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100 px-4 py-8 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        {{-- Logo and Title --}}
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">NoteLoom</h1>
            <p class="mt-2 text-sm text-slate-600">Sign in to your account</p>
        </div>

        {{-- Login Card --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
            <div class="px-6 py-8 sm:px-8 sm:py-10">
                <form wire:submit="login" class="space-y-6">
                    {{-- Email Field --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-2">
                            Email address
                        </label>
                        <input
                            type="email"
                            id="email"
                            wire:model="email"
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 text-slate-900 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition duration-150 ease-in-out
                                   @error('email') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="demo@noteloom.com"
                            autofocus
                            autocomplete="email"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Password Field --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-2">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            wire:model="password"
                            class="w-full px-4 py-3 rounded-lg border border-slate-300 text-slate-900 placeholder-slate-400
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                   transition duration-150 ease-in-out
                                   @error('password') border-red-500 focus:ring-red-500 @enderror"
                            placeholder="••••••••"
                            autocomplete="current-password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- Remember Me --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center group cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="remember"
                                class="w-4 h-4 rounded border-slate-300 text-blue-600
                                       focus:ring-2 focus:ring-blue-500 focus:ring-offset-0
                                       transition duration-150 ease-in-out cursor-pointer"
                            >
                            <span class="ml-2 text-sm text-slate-700 group-hover:text-slate-900 transition">
                                Remember me
                            </span>
                        </label>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700 transition">
                            Forgot password?
                        </a>
                    </div>

                    {{-- Submit Button --}}
                    <button
                        type="submit"
                        class="w-full py-3 px-4 rounded-lg font-medium text-white
                               bg-gradient-to-r from-blue-500 to-blue-600
                               hover:from-blue-600 hover:to-blue-700
                               focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                               shadow-lg hover:shadow-xl
                               transform hover:-translate-y-0.5
                               transition-all duration-150 ease-in-out
                               disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Sign in</span>
                        <span wire:loading class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Signing in...
                        </span>
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200 sm:px-8">
                <p class="text-center text-sm text-slate-600">
                    Don't have an account?
                    <a href="#" class="font-medium text-blue-600 hover:text-blue-700 transition">
                        Sign up
                    </a>
                </p>
            </div>
        </div>

        {{-- Additional Info --}}
        <p class="mt-8 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} NoteLoom. All rights reserved.
        </p>
    </div>
</div>
