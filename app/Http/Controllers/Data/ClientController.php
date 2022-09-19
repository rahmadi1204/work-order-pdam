<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Http\Traits\UploadFile;
use App\Models\Data\Area;
use App\Models\Data\Client;
use App\Models\Data\Kelurahan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    // trait upload file
    use UploadFile;
    public function index()
    {
        // view halaman client
        $title = 'Data Pelanggan';
        return view('pages.data.client', compact([
            'title',
        ]));
    }

    public function query($request)
    {
        // query data client
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
        // cari berdasarkan status
        if ($request->status != 'all') {
            $clients->where('is_active', $request->status);
        }
        if ($request->date != null) {
            $start_date = substr($request->date, 0, 10);
            $end_date = substr($request->date, 13, 10);
            $clients->whereBetween('tgl_masuk', [$start_date, $end_date]);
        }
        return $clients;
    }
    public function get(Request $request)
    {
        $data = $this->query($request)->take(5);
        return DataTables::of($data)
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
            })
            ->addIndexColumn()
            ->editColumn('tgl_masuk', function ($data) {
                return Carbon::parse($data->tgl_masuk)->format('Y M d') ?? '-';
            })
            ->addColumn('status', function ($data) {
                if ($data->is_active == 1) {
                    return '<span class="badge badge-success">Aktif</span>';
                } else {
                    return '<span class="badge badge-danger">Tidak Aktif</span>';
                }
            })
            ->addColumn('action', function ($data) {
                $action = '<div class="d-flex justify-content-center">';
                $action .= '<a href="' . route('client.edit', $data->no_sambungan) . '" class="btn btn-info mx-1"><i class="fas fa-pencil-alt"></i>Edit</a>';
                $action .= '<a href="#" onclick="deleteConfirm(' . $data->id . ',`' . $data->nama . '`)" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i>Delete</a>';
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['checkbox', 'status', 'action'])
            ->make(true);
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
        $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();
        return view('pages.data.client_form', compact([
            'title',
            'areas',
            'kelurahans',
        ]));
    }
    public function store(Request $request)
    {
        // validasi data
        $request->validate([
            'nama' => 'required',
            'no_sambungan' => 'required|unique:clients,no_sambungan',
            'id_area' => 'required',
            'id_kelurahan' => 'required',
            'no_urut' => 'required',
            'id_pelanggan' => 'required|unique:clients,id_pelanggan',
            'alamat' => 'required',
            'tgl_masuk' => 'required|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'no_sambungan.required' => 'Nomor sambungan tidak boleh kosong',
            'no_sambungan.unique' => 'Nomor sambungan sudah terdaftar',
            'id_area.required' => 'Area tidak boleh kosong',
            'id_kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'no_urut.required' => 'Nomor urut tidak boleh kosong',
            'id_pelanggan.required' => 'ID Pelanggan tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'tgl_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tgl_masuk.date' => 'Format tanggal tidak valid',
            'latitude.numeric' => 'Format latitude tidak valid',
            'longitude.numeric' => 'Format longitude tidak valid',
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try {
            // proses simpan data
            $idKecamatan = substr(str_replace('AREA-', '', $request->id_area), 0, 2);
            $idWilayah = substr(str_replace('AREA-', '', $request->id_area), 3, 2);
            $idJalan = substr(str_replace('AREA-', '', $request->id_area), 6, 2);
            $client = new Client();
            $client->nama = $request->nama;
            $client->no_sambungan = $request->no_sambungan;
            $client->id_area = $request->id_area;
            $client->id_kelurahan = $request->id_kelurahan;
            $client->no_urut = $request->no_urut;
            $client->id_pelanggan = $request->id_pelanggan;
            $client->alamat = $request->alamat;
            $client->tgl_masuk = $request->tgl_masuk;
            $client->no_telpon = $request->no_telpon;
            $client->no_hp = $request->no_hp;
            $client->id_kecamatan = $idKecamatan;
            $client->id_wilayah = $idKecamatan . '.' . $idWilayah;
            $client->id_jalan = $idKecamatan . '.' . $idWilayah . '.' . $idJalan;
            $client->latitude = $request->latitude;
            $client->longitude = $request->longitude;
            $client->is_active = $request->is_active == 'on' ? 1 : 0;
            // upload file
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $destinationPath = '/images/client';
                $fileData = $this->uploadPublic($image, $destinationPath, $client, 'image');
                $client->image = $fileData['path'] . '/' . $fileData['file_name'];
            }
            $client->save();
            DB::commit();
            return redirect()->route('client')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function edit($id)
    {
        // view form edit client
        $title = 'Edit Data Pelanggan';
        $data = Client::where('no_sambungan', $id)->firstOrFail();
        $areas = Area::orderBy('nama_jalan', 'asc')->get();
        $kelurahans = Kelurahan::orderBy('nama_kelurahan', 'asc')->get();
        return view('pages.data.client_form', compact([
            'title',
            'data',
            'areas',
            'kelurahans',
        ]));
    }
    public function update(Request $request, $id)
    {
        // validasi data
        $request->validate([
            'nama' => 'required',
            'no_sambungan' => 'required|unique:clients,no_sambungan,' . $id . ',id',
            'id_area' => 'required',
            'id_kelurahan' => 'required',
            'no_urut' => 'required',
            'id_pelanggan' => 'required|unique:clients,id_pelanggan,' . $id . ',id',
            'alamat' => 'required',
            'tgl_masuk' => 'required|date',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ], [
            'nama.required' => 'Nama tidak boleh kosong',
            'no_sambungan.required' => 'Nomor sambungan tidak boleh kosong',
            'no_sambungan.unique' => 'Nomor sambungan sudah terdaftar',
            'id_area.required' => 'Area tidak boleh kosong',
            'id_kelurahan.required' => 'Kelurahan tidak boleh kosong',
            'no_urut.required' => 'Nomor urut tidak boleh kosong',
            'id_pelanggan.required' => 'ID Pelanggan tidak boleh kosong',
            'alamat.required' => 'Alamat tidak boleh kosong',
            'tgl_masuk.required' => 'Tanggal masuk tidak boleh kosong',
            'tgl_masuk.date' => 'Format tanggal tidak valid',
            'latitude.numeric' => 'Format latitude tidak valid',
            'longitude.numeric' => 'Format longitude tidak valid',
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try {
            // proses simpan data
            $idKecamatan = substr(str_replace('AREA-', '', $request->id_area), 0, 2);
            $idWilayah = substr(str_replace('AREA-', '', $request->id_area), 3, 2);
            $idJalan = substr(str_replace('AREA-', '', $request->id_area), 6, 2);
            $client = Client::findOrFail($id);
            $client->nama = $request->nama;
            $client->no_sambungan = $request->no_sambungan;
            $client->id_area = $request->id_area;
            $client->id_kelurahan = $request->id_kelurahan;
            $client->no_urut = $request->no_urut;
            $client->id_pelanggan = $request->id_pelanggan;
            $client->alamat = $request->alamat;
            $client->tgl_masuk = $request->tgl_masuk;
            $client->no_telpon = $request->no_telpon;
            $client->no_hp = $request->no_hp;
            $client->id_kecamatan = $idKecamatan;
            $client->id_wilayah = $idKecamatan . '.' . $idWilayah;
            $client->id_jalan = $idKecamatan . '.' . $idWilayah . '.' . $idJalan;
            $client->latitude = $request->latitude;
            $client->longitude = $request->longitude;
            $client->is_active = $request->is_active == 'on' ? 1 : 0;
            // upload file
            if ($request->hasFile('image')) {
                // hapus file lama
                if ($client->image != null) {
                    $oldImage = $client->image;
                    $this->deleteFile($oldImage);
                }
                $image = $request->file('image');
                $destinationPath = '/images/client';
                $fileData = $this->uploadPublic($image, $destinationPath, $client, 'image');
                $client->image = $fileData['path'] . '/' . $fileData['file_name'];
            }
            $client->save();
            DB::commit();
            return redirect()->route('client')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
    public function destroy($id)
    {
        // proses hapus data pelanggan
        DB::beginTransaction();
        try {
            $staff = Client::findOrFail($id);
            if ($staff->image != null) {
                $oldImage = $staff->image;
                $this->deleteFile($oldImage);
            }
            $staff->delete();
            DB::commit();
            return redirect()->route('staff')->with('success', 'Data pelanggan berhasil dihapus');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data pelanggan gagal dihapus : ' . $th->getMessage());
        }
    }
}
