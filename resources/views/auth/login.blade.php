<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-white">Selamat Datang</h2>
            <p class="text-gray-400 text-sm mt-1">Silakan login untuk melanjutkan.</p>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
            <x-text-input id="email" class="block mt-2 w-full bg-gray-950 border-gray-700 text-white placeholder-gray-600 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-3" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-300" />
            <x-text-input id="password" class="block mt-2 w-full bg-gray-950 border-gray-700 text-white placeholder-gray-600 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-3"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-700 bg-gray-950 text-indigo-600 shadow-sm focus:ring-indigo-500 cursor-pointer" name="remember">
                <span class="ms-2 text-sm text-gray-400 select-none">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-indigo-400 hover:text-indigo-300 rounded-md focus:outline-none transition" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-500 py-3.5 rounded-xl text-base font-bold shadow-lg shadow-indigo-600/30 transition-transform transform hover:-translate-y-1">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
        
        @if (Route::has('register'))
            <div class="text-center mt-6 text-sm text-gray-400">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-indigo-400 hover:text-indigo-300 transition">Daftar di sini</a>
            </div>
        @endif
    </form>
</x-guest-layout>