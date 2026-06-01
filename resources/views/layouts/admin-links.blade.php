<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/>
    </svg>
    Dashboard
</a>

<!-- Kelola Pengajuan -->
<a href="{{ route('admin.pengajuans.index') }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition duration-150 {{ request()->routeIs('admin.pengajuans.*') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
    </svg>
    Kelola Pengajuan
</a>

<!-- Kelola Pengaduan -->
<a href="{{ route('admin.pengaduans.index') }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition duration-150 {{ request()->routeIs('admin.pengaduans.*') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
    </svg>
    Kelola Pengaduan
</a>

<!-- Program Bantuan -->
<a href="{{ route('admin.programs.index') }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition duration-150 {{ request()->routeIs('admin.programs.*') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.62 48.62 0 0112 20.9c4.956 0 9.31-1.766 12.23-4.707-.13-2.115-.298-4.234-.51-6.347M12 2.25l-9 4.75 9 4.75 9-4.75-9-4.75z"/>
    </svg>
    Program Bantuan
</a>

<!-- Manajemen Menu -->
<a href="{{ route('admin.menus.index') }}" 
   class="flex items-center gap-3 px-4 py-3 rounded-xl text-xs font-semibold transition duration-150 {{ request()->routeIs('admin.menus.*') ? 'bg-indigo-50 text-indigo-700 font-bold border border-indigo-100/50' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}">
    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
    </svg>
    Manajemen Menu
</a>
