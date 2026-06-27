<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('id', '!=', auth()->id())->count();
        $totalWatchlists = Watchlist::count();
        
        $users = User::where('id', '!=', auth()->id())->latest()->get();
        
        return view('admin.dashboard', compact('totalUsers', 'totalWatchlists', 'users'));
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors('Anda tidak bisa menghapus akun diri sendiri!');
        }

        $user->delete();

        return back()->with('status', 'Akun user berhasil dihapus!');
    }
}