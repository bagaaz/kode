<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Perfume;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'totals' => [
                'users' => User::count(),
                'admins' => User::where('role', 'admin')->count(),
                'perfumes' => Perfume::count(),
                'active_perfumes' => Perfume::where('is_active', true)->count(),
            ],
            'recentUsers' => User::latest()->take(5)->get(),
            'recentPerfumes' => Perfume::latest()->take(5)->get(),
        ]);
    }
}
