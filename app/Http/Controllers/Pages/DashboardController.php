<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $countClients = Client::count();
        return view('pages.dashboard', compact([
            'title',
            'countClients',
        ]));
    }
}
