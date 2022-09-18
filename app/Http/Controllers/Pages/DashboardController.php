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
        $wilUnknown = Client::where('id_kecamatan', '!=', 01)
            ->where('id_kecamatan', '!=', 02)
            ->where('id_kecamatan', '!=', 03)
            ->count();
        $wil = [
            $wil1,
            $wil2,
            $wil3,
            $wilUnknown,
        ];
        $wilayah = [
            'KEC. KARTOHARJO',
            'KEC. TAMAN',
            'KEC. MANGUNHARJO',
            'UNKNOWN',
        ];
        $woBelum = [
            2,
            3,
            4,
            7,
            8,
            9,
            10,
        ];
        $woProses = [
            1,
            5,
            6,
            1,
            5,
            6,
            9,
        ];
        $woSelesai = [
            1,
            2,
            3,
            4,
            5,
            6,
            7,
        ];
        $woTotal = [
            4,
            10,
            13,
            12,
            18,
            21,
            26,
        ];
        $days = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
            'Minggu',
        ];
        return view('pages.dashboard', compact([
            'title',
            'countClients',
            'countStaffs',
            'wil',
            'wilayah',
            'days',
            'woBelum',
            'woProses',
            'woSelesai',
            'woTotal',
        ]));
    }
}
