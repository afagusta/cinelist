<x-app-layout>
    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('status'))
                <div class="mb-6 px-4 py-3 bg-green-900/40 border border-green-800 text-green-400 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-900/40 border border-red-800 text-red-400 rounded-xl font-medium flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="mb-8 px-4 sm:px-0">
                <h1 class="text-3xl font-extrabold text-white">Panel Admin</h1>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 px-4 sm:px-0">
                <div class="bg-gray-900 p-4 sm:p-6 rounded-2xl shadow-xl border border-gray-800 flex items-center hover:border-indigo-500 transition">
                    <div class="p-3 sm:p-4 bg-indigo-900/30 text-indigo-400 rounded-2xl mr-4 sm:mr-5 border border-indigo-800/50">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Pengguna</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white">{{ $totalUsers }}</h2>
                    </div>
                </div>

                <div class="bg-gray-900 p-4 sm:p-6 rounded-2xl shadow-xl border border-gray-800 flex items-center hover:border-emerald-500 transition">
                    <div class="p-3 sm:p-4 bg-emerald-900/30 text-emerald-400 rounded-2xl mr-4 sm:mr-5 border border-emerald-800/50">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Film Disimpan</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-white">{{ $totalWatchlists }}</h2>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900 rounded-2xl shadow-xl border border-gray-800 overflow-hidden mx-4 sm:mx-0">
                <div class="px-6 py-5 border-b border-gray-800">
                    <h3 class="text-lg font-bold text-white">Manajemen Pengguna</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-gray-300">
                        <thead>
                            <tr class="bg-gray-800/50 text-gray-400 text-xs uppercase tracking-wider">
                                <th class="px-3 sm:px-6 py-4 font-bold">No</th>
                                <th class="px-3 sm:px-6 py-4 font-bold">Nama</th>
                                <th class="hidden sm:table-cell px-3 sm:px-6 py-4 font-bold">Email</th>
                                <th class="hidden md:table-cell px-3 sm:px-6 py-4 font-bold">Bergabung</th>
                                <th class="px-3 sm:px-6 py-4 font-bold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($users as $index => $user)
                                <tr class="hover:bg-gray-800/50 transition duration-150">
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm text-gray-400 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-sm text-white font-bold">{{ $user->name }}</td>
                                    <td class="hidden sm:table-cell px-3 sm:px-6 py-3 sm:py-4 text-sm text-gray-300">{{ $user->email }}</td>
                                    <td class="hidden md:table-cell px-3 sm:px-6 py-3 sm:py-4 text-sm text-gray-400">{{ $user->created_at->format('d M Y') }}</td>
                                    <td class="px-3 sm:px-6 py-3 sm:py-4 text-center">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Anda yakin ingin menghapus akun {{ $user->name }} secara permanen? Semua data watchlist milik user ini juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 text-xs font-bold bg-red-900/20 hover:bg-red-900/40 px-4 py-2 rounded-lg transition border border-red-800/50">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                        Belum ada pengguna lain yang terdaftar selain Anda.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>