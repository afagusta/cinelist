<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div class="text-center mb-8">
            <h2 class="text-2xl font-extrabold text-white">Buat Akun Baru</h2>
            <p class="text-gray-400 text-sm mt-1">Bergabunglah dengan CineList sekarang.</p>
        </div>

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-gray-300 font-bold" />
            <x-text-input id="name" class="block mt-2 w-full bg-gray-950 border-gray-700 text-white placeholder-gray-600 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-3" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300 font-bold" />
            <x-text-input id="email" class="block mt-2 w-full bg-gray-950 border-gray-700 text-white placeholder-gray-600 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-3" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-300 font-bold" />
            <x-text-input id="password" class="block mt-2 w-full bg-gray-950 border-gray-700 text-white placeholder-gray-600 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-3"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-gray-300 font-bold" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full bg-gray-950 border-gray-700 text-white placeholder-gray-600 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 py-3"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <x-primary-button class="w-full justify-center bg-indigo-600 hover:bg-indigo-500 py-3.5 rounded-xl text-base font-bold shadow-lg shadow-indigo-600/30 transition-transform transform hover:-translate-y-1">
                {{ __('DAFTAR') }}
            </x-primary-button>
        </div>
        
        <div class="text-center mt-6 text-sm text-gray-400">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="font-bold text-indigo-400 hover:text-indigo-300 transition">Login di sini</a>
        </div>
    </form>
</x-guest-layout>