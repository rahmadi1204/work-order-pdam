<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use App\Models\Data\Staff;
use App\Models\Transaction\WorkOrder;

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
            WorkOrder::where('tgl_work_order', now()->startOfWeek())->where('status', 'pending')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(1))->where('status', 'pending')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(2))->where('status', 'pending')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(3))->where('status', 'pending')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(4))->where('status', 'pending')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(5))->where('status', 'pending')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(6))->where('status', 'pending')->count(),
        ];
        $woProses = [
            WorkOrder::where('tgl_work_order', now()->startOfWeek())->where('status', 'proses')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(1))->where('status', 'proses')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(2))->where('status', 'proses')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(3))->where('status', 'proses')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(4))->where('status', 'proses')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(5))->where('status', 'proses')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(6))->where('status', 'proses')->count(),
        ];
        $woSelesai = [
            WorkOrder::where('tgl_work_order', now()->startOfWeek())->where('status', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(1))->where('status', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(2))->where('status', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(3))->where('status', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(4))->where('status', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(5))->where('status', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(6))->where('status', 'selesai')->count(),
        ];
        $woTotal = [
            WorkOrder::where('tgl_work_order', now()->startOfWeek())->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(1))->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(2))->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(3))->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(4))->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(5))->count(),
            WorkOrder::where('tgl_work_order', now()->startOfWeek()->addDays(6))->count(),
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
        $newWorkOrder = WorkOrder::where('status', 'pending')->count();
        $processWorkOrderPercent = WorkOrder::where('status', 'proses')->count() / WorkOrder::count() * 100;
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
            'newWorkOrder',
            'processWorkOrderPercent',
        ]));
    }
}
