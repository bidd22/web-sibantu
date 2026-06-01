<div class="flex items-center justify-between w-full">
    <div class="flex items-center gap-3 min-w-0">
        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-sm font-bold shadow-md shadow-indigo-500/10 shrink-0">
            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
        </div>
        <div class="text-left min-w-0">
            <div class="text-xs font-bold text-slate-800 truncate" title="{{ Auth::user()->name }}">{{ Auth::user()->name }}</div>
            <div class="text-[10px] font-semibold text-slate-400">Administrator</div>
        </div>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="inline-flex shrink-0">
        @csrf
        <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition duration-150" title="Keluar">
            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
            </svg>
        </button>
    </form>
</div>
