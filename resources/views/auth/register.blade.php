<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-800 tracking-tight">Daftar Akun Baru</h2>
        <p class="text-sm text-slate-500 mt-1">Buat akun Anda untuk mulai mengajukan dan melacak bantuan</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold mb-1" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold mb-1" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Kata Sandi')" class="text-slate-700 font-semibold mb-1" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-slate-700 font-semibold mb-1" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
