<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use App\Models\Data\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        // view halaman dashboard
        $title = 'Dashboard';
        $countClients = Client::count();
        $countStaffs = Staff::count();
        $wil1 = Client::where('id_kecamatan', 01)->count();
        $wil2 = Client::where('id_kecamatan', 02)->count();
        $wil3 = Client::where('id_kecamatan', 03)->count();
        $wil = [
            $wil1,
            $wil2,
            $wil3,
        ];
        $wilayah = [
            'KEC. KARTOHARJO',
            'KEC. TAMAN',
            'KEC. MANGUNHARJO',
        ];
        return view('pages.dashboard', compact([
            'title',
            'countClients',
            'countStaffs',
            'wil',
            'wilayah',
        ]));
    }
}
