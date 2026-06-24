<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Hitung statistik (mengecualikan admin yang sedang login)
        $totalUsers = User::where('id', '!=', auth()->id())->count();
        $totalWatchlists = Watchlist::count();
        
        // Ambil data user untuk ditampilkan di tabel (mengecualikan admin yang sedang login)
        $users = User::where('id', '!=', auth()->id())->latest()->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalWatchlists', 'users'));
    }

    // Fungsi untuk menghapus akun user
    public function destroyUser(User $user)
    {
        // Pastikan Admin tidak menghapus dirinya sendiri secara tidak sengaja
        if ($user->id === auth()->id()) {
            return back()->withErrors('Anda tidak bisa menghapus akun diri sendiri!');
        }

        $user->delete();

        return back()->with('status', 'Akun user berhasil dihapus!');
    }
}