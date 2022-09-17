<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // view halaman client
        $title = 'Data Pelanggan';
        $clients = Client::paginate(10);
        return view('pages.data.client', compact([
            'title',
            'clients',
        ]));
    }
    public function search(Request $request)
    {
        // proses cari data client
        $title = 'Data Pelanggan';
        $clients = Client::query();
        // cari berdasarkan nama
        if ($request->has('name')) {
            $clients->where('nama', 'like', '%' . $request->name . '%');
        }
        // cari berdasarkan nomor sambungan
        if ($request->has('no_sambungan')) {
            $clients->where('no_sambungan', 'like', '%' . $request->no_sambungan . '%');
        }
        // cari berdasarkan alamat
        if ($request->has('alamat')) {
            $clients->where('alamat', 'like', '%' . $request->alamat . '%');
        }
        $clients = $clients->paginate(10);
        return view('pages.data.client', compact([
            'title',
            'clients',
        ]));
    }
    public function filter(Request $request)
    {
        // proses filter status client
        $title = 'Data Pelanggan';
        $clients = Client::query();
        // filter berdasarkan status
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
        // view form tambah client
        $title = 'Tambah Data Pelanggan';
        return view('pages.data.client_form', compact([
            'title',
        ]));
    }
}
