<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use App\Models\Data\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $countClients = Client::count();
        $countStaffs = Staff::count();
        return view('pages.dashboard', compact([
            'title',
            'countClients',
            'countStaffs',
        ]));
    }
}
