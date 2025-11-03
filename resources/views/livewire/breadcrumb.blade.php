{{-- Breadcrumb --}}
<nav class="mb-6">
    <ol class="flex items-center space-x-2 text-sm">
        <li>
            <a href="{{ route('dashboard') }}" class="text-slate-600 hover:text-slate-900 transition">
                Dashboard
            </a>
        </li>
        <li class="text-slate-400">/</li>
        <li class="text-slate-900 font-medium">{{ $currentPage }}</li>
    </ol>
</nav>
