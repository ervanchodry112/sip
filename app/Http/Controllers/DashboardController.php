<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data = [
            'title'     => 'Dashboard',
            'users'     => User::count(),
            'products'  => Barang::whereNull('deleted_at')->count(),
            'selling'   => Penjualan::sum('total'),
        ];

        return view('pages.dashboard', $data);
    }

}
