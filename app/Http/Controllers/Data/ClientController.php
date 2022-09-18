<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Data\Area;
use App\Models\Data\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        // view halaman client
        $title = 'Data Pelanggan';
        $clients = Client::with(['area'])->paginate(10);
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
    public function check(Request $request)
    {
        try {
            // proses validasi nomor sambungan
            $idPelanggan = substr($request->id_pelanggan, 1, 6);
            $client = Client::where('no_sambungan', 'like', $idPelanggan . '%')->orderby('no_sambungan', 'desc')->take(1)->value('no_sambungan');
            $noUrut = substr($client, 6, 4);
            if ($client) {
                return response()->json([
                    'status' => 'success',
                    'data' => '0' . $client,
                    'no_urut' => $noUrut,
                    'no_sambungan' => $idPelanggan . $noUrut,
                ]);
            } else {
                return response()->json([
                    'status' => 'not found',
                    'data' => '0' . $idPelanggan . '0001',
                    'no_urut' => '0001',
                    'no_sambungan' => $idPelanggan . '0001',
                ]);
            }
        } catch (\Throwable$th) {
            return response()->json($th->getMessage());
        }
    }
    public function create()
    {
        // view form tambah client
        $title = 'Tambah Data Pelanggan';
        $areas = Area::orderBy('nama_jalan', 'asc')->get();
        return view('pages.data.client_form', compact([
            'title',
            'areas',
        ]));
    }
    public function store(Request $request)
    {
        dd($request->all());
        // proses tambah client
        $request->validate([
            'nama' => 'required',
            'no_sambungan' => 'required|unique:clients,no_sambungan',
            'alamat' => 'required',
            'id_area' => 'required',
        ]);
        $client = Client::create([
            'nama' => $request->nama,
            'no_sambungan' => $request->no_sambungan,
            'alamat' => $request->alamat,
            'id_area' => $request->id_area,
        ]);
        if ($client) {
            return redirect()->route('client')->with('success', 'Data pelanggan berhasil ditambahkan');
        } else {
            return redirect()->back()->with('error', 'Data pelanggan gagal ditambahkan : ' . $client->errors());
        }
    }

}
