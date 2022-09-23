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
        $title = 'Halaman Utama';
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
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(6)->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(5)->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(4)->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(3)->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(2)->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(1)->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->format('Y-m-d') . '%')->where('status_work_order', 'pending')->count(),
        ];
        $woProses = [
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(6)->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(5)->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(4)->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(3)->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(2)->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(1)->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->format('Y-m-d') . '%')->where('status_work_order', 'proses')->count(),
        ];
        $woSelesai = [
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(6)->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(5)->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(4)->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(3)->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(2)->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(1)->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->format('Y-m-d') . '%')->where('status_work_order', 'selesai')->count(),
        ];
        $woTotal = [
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(6)->format('Y-m-d') . '%')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(5)->format('Y-m-d') . '%')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(4)->format('Y-m-d') . '%')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(3)->format('Y-m-d') . '%')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(2)->format('Y-m-d') . '%')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->subDay(1)->format('Y-m-d') . '%')->count(),
            WorkOrder::where('tgl_work_order', 'like', now()->format('Y-m-d') . '%')->count(),
        ];
        $days = [
            now()->subDay(6)->format('d M'),
            now()->subDay(5)->format('d M'),
            now()->subDay(4)->format('d M'),
            now()->subDay(3)->format('d M'),
            now()->subDay(2)->format('d M'),
            now()->subDay(1)->format('d M'),
            now()->format('d M'),
        ];
        $newWorkOrder = WorkOrder::where('status_work_order', 'pending')->count();
        $processWorkOrder = WorkOrder::where('status_work_order', 'proses')->count();
        $doneWorkOrder = WorkOrder::where('status_work_order', 'selesai')->count();
        $totalWorkOrder = WorkOrder::count();
        $dividing = WorkOrder::count();
        if ($dividing == 0) {
            $dividing = 1;
        }
        $processWorkOrderPercent = WorkOrder::where('status_work_order', 'proses')->count() / $dividing * 100;
        $processWorkOrderPercent = round($processWorkOrderPercent, 2);
        $doneWorkOrderPercent = WorkOrder::where('status_work_order', 'selesai')->count() / $dividing * 100;
        $doneWorkOrderPercent = round($doneWorkOrderPercent, 2);
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
            'processWorkOrder',
            'doneWorkOrder',
            'totalWorkOrder',
            'processWorkOrderPercent',
            'doneWorkOrderPercent',
        ]));
    }
}
