<x-guest-layout>
    <div class="flex justify-center mb-3">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-purple-50 border border-purple-100/60 rounded-full text-[10px] font-bold text-purple-600 uppercase tracking-wider shadow-sm">
            <span class="w-1.5 h-1.5 rounded-full bg-purple-500 animate-pulse"></span>
            ✨ Bergabung SIBANTU
        </div>
    </div>

    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Daftar Akun Baru</h2>
        <p class="text-xs text-slate-500 mt-1.5 max-w-[280px] mx-auto">Buat akun Anda untuk mulai mengajukan dan melacak bantuan</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block w-full mt-1.5" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1.5" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" />

            <x-text-input id="password" class="block w-full mt-1.5"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" />

            <x-text-input id="password_confirmation" class="block w-full mt-1.5"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <!-- Action Button -->
        <div class="mt-6">
            <x-primary-button>
                {{ __('Daftar Sekarang') }}
            </x-primary-button>
        </div>

        <!-- Login Link -->
        <div class="mt-6 text-center border-t border-slate-100 pt-5">
            <p class="text-sm text-slate-500">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-750 transition duration-150">
                    Masuk
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
