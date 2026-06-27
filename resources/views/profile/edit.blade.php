<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="mb-8 px-4 sm:px-0">
                <h2 class="text-3xl font-extrabold text-white tracking-tight">
                    {{ __('Pengaturan Profil') }}
                </h2>
                <p class="text-gray-400 mt-2">Kelola informasi akun dan keamanan Anda.</p>
            </div>

            <div class="p-6 sm:p-10 bg-gray-900 shadow-xl border border-gray-800 rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-gray-900 shadow-xl border border-gray-800 rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-gray-900 shadow-xl border border-gray-800 rounded-3xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>