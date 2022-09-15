<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        return view('pages.dashboard', compact('title'));
    }
}
