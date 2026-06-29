<div x-show="loading"
     x-cloak
     class="fixed inset-0 z-50 flex items-center justify-center bg-gray-950/80 backdrop-blur-sm">
    <div class="flex flex-col items-center gap-4">
        <div class="relative w-16 h-16">
            <div class="w-full h-full border-4 border-gray-800 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-indigo-500 rounded-full animate-spin border-t-transparent border-r-transparent"></div>
        </div>
        <span class="text-gray-400 text-lg font-semibold animate-pulse">Memuat data...</span>
    </div>
</div>
