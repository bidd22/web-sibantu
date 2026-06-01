<x-guest-layout>
    <div class="flex justify-center mb-3">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 border border-indigo-100/60 rounded-full text-[10px] font-bold text-indigo-600 uppercase tracking-wider shadow-sm">
            <span class="w-1.5 h-1.5 rounded-full bg-indigo-500 animate-pulse"></span>
            🔑 Portal Pengguna
        </div>
    </div>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h2>
        <p class="text-xs text-slate-500 mt-1.5 max-w-[280px] mx-auto">Silakan masuk ke akun Anda untuk mengelola pengajuan bantuan</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1.5" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block w-full mt-1.5"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-500/20 focus:ring-4 w-4 h-4 transition duration-150 cursor-pointer" name="remember">
                <span class="ms-2 text-xs font-semibold text-slate-500">{{ __('Ingat Saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 transition" href="{{ route('password.request') }}">
                    {{ __('Lupa kata sandi?') }}
                </a>
            @endif
        </div>

        <!-- Action Button -->
        <div class="mt-6">
            <x-primary-button>
                {{ __('Masuk') }}
            </x-primary-button>
        </div>

        <!-- Register Link -->
        <div class="mt-6 text-center border-t border-slate-100 pt-5">
            <p class="text-sm text-slate-500">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-750 transition duration-150">
                    Daftar Sekarang
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
