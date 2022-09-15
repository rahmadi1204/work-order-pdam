<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    // view halaman client
    public function index()
    {
        $title = 'Data Pelanggan';
        $clients = Client::paginate(10);
        return view('pages.data.client', compact([
            'title',
            'clients',
        ]));
    }
    // proses cari data client
    public function search(Request $request)
    {
        $title = 'Data Pelanggan';
        $clients = Client::query();
        if ($request->has('name')) {
            $clients->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->has('no_sambungan')) {
            $clients->where('no_sambungan', 'like', '%' . $request->no_sambungan . '%');
        }
        if ($request->has('alamat')) {
            $clients->where('alamat', 'like', '%' . $request->alamat . '%');
        }
        $clients = $clients->paginate(10);
        return view('pages.data.client', compact([
            'title',
            'clients',
        ]));
    }
    // proses filter status client
    public function filter(Request $request)
    {
        $title = 'Data Pelanggan';
        $clients = Client::query();
        if ($request->has('status') && $request->status != 'all') {
            $clients->where('is_active', $request->status);
        }
        $clients = $clients->paginate(10);
        return view('pages.data.client', compact([
            'title',
            'clients',
        ]));
    }
    public function create()
    {
        $title = 'Tambah Data Pelanggan';
        return view('pages.data.client_create', compact([
            'title',
        ]));
    }
}
