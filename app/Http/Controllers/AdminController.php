<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::role('user')->count();
        $totalWatchlists = Watchlist::count();
        
        return view('admin.dashboard', compact('totalUsers', 'totalWatchlists'));
    }
}