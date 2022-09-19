<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use App\Models\Data\Staff;
use App\Models\Transaction\WorkOrder;
use App\Models\Types\TypeWorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderController extends Controller
{
    public function index()
    {
        $title = 'Work Order';
        return view('pages.transaction.work_order', compact([
            'title',
        ]));
    }
    public function query($request)
    {
        $query = WorkOrder::with([
            'client' => function ($query) {
                $query->select('no_sambungan', 'nama');
            },
            'staff' => function ($query) {
                $query->select('kode_jabatan', 'nama');
            },
            'type' => function ($query) {
                $query->select('kode_work_order', 'jenis_work_order');
            },
        ]);
        if ($request->type_id != null) {
            $query->where('type_id', $request->type_id);
        }
        if ($request->name != null) {
            $query->whereRelation('staff', 'nama', 'like', '%' . $request->name . '%');
        }
        if ($request->client != null) {
            $query->whereRelation('client', 'nama', 'like', '%' . $request->client . '%');
        }
        if ($request->status != 'all') {
            $query->where('status_work_order', $request->status);
        }
        if ($request->date != null) {
            $start_date = substr($request->date, 0, 10);
            $end_date = substr($request->date, 13, 10);
            $query->whereBetween('tgl_work_order', [$start_date, $end_date]);
        }
        return $query;

    }
    public function get(Request $request)
    {
        $data = $this->query($request);
        return DataTables::of($data)
            ->addColumn('checkbox', function ($data) {
                return '<input type="checkbox" name="id[]" value="' . $data->id . '">';
            })
            ->addIndexColumn()
            ->editColumn('tgl_work_order', function ($data) {
                return Carbon::parse($data->tgl_work_order)->format('Y M d') ?? '-';
            })
            ->editColumn('type_id', function ($data) {
                $typeId = $data->type_id ?? '-';
                $typeName = $data->type->jenis_work_order ?? '-';
                return $typeId . '<br>' . $typeName;
            })
            ->editColumn('staff_id', function ($data) {
                $nama = $data->staff->nama ?? '-';
                $nip = $data->staff->nip ?? '-';
                return $nama . '<br>' . $nip;
            })
            ->editColumn('client_id', function ($data) {
                return $data->client->nama ?? '-';
            })
            ->addColumn('status_work_order', function ($data) {
                if ($data->status_work_order == 'pending') {
                    return '<span class="badge badge-warning">' . strtoupper($data->status_work_order) . '</span>';
                } else if ($data->status_work_order == 'proses') {
                    return '<span class="badge badge-info">' . strtoupper($data->status_work_order) . '</span>';
                } else if ($data->status_work_order == 'selesai') {
                    return '<span class="badge badge-success">' . strtoupper($data->status_work_order) . '</span>';
                } else if ($data->status_work_order == 'batal') {
                    return '<span class="badge badge-danger">' . strtoupper($data->status_work_order) . '</span>';
                } else {
                    return '<span class="badge badge-secondary">' . strtoupper($data->status_work_order) . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                $action = '<div class="d-flex justify-content-center">';
                $action .= '<a href="' . url('work-order/edit', $data->uuid) . '" class="btn btn-info mx-1"><i class="fas fa-pencil-alt"></i>Edit</a>';
                $action .= '<a href="#" onclick="deleteConfirm(' . $data->id . ',`' . $data->nama . '`)" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i>Delete</a>';
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['checkbox', 'type_id', 'staff_id', 'status_work_order', 'action'])
            ->make(true);
    }
    public function create()
    {
        $title = 'Tambah Data Work Order';
        $types = TypeWorkOrder::all();
        $staff = Staff::where('kategori_jabatan', '!=', 'DIREKSI')->get();
        return view('pages.transaction.work_order_form', compact([
            'title',
            'types',
            'staff',
        ]));
    }
    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'tgl_work_order' => 'required',
            'jenis_work_order' => 'required',
            'staff_id' => 'required',
        ], [
            'tgl_work_order.required' => 'Tanggal Work Order tidak boleh kosong',
            'jenis_work_order.required' => 'Jenis Work Order tidak boleh kosong',
            'staff_id.required' => 'Staff tidak boleh kosong',
        ]
        );
        // simpan data
        DB::beginTransaction();
        try {
            $workOrder = new WorkOrder();
            $workOrder->tgl_work_order = Carbon::parse($request->tgl_work_order)->format('Y-m-d H:i:s');
            $workOrder->type_id = $request->jenis_work_order;
            $workOrder->staff_id = $request->staff_id;
            $workOrder->client_id = $request->client_id;
            $workOrder->document_id = $request->document_id;
            $workOrder->latitude = $request->latitude;
            $workOrder->longitude = $request->longitude;
            $workOrder->google_maps = $request->google_maps;
            $workOrder->deskripsi = $request->deskripsi;
            $workOrder->keterangan = $request->keterangan;
            $workOrder->save();
            DB::commit();
            return redirect()->route('work-order')->with('success', 'Data Work Order berhasil ditambahkan');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Work Order gagal ditambahkan : ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $title = 'Edit Data Work Order';
        $data = WorkOrder::where('uuid', $id)->first();
        $types = TypeWorkOrder::all();
        $staff = Staff::where('kategori_jabatan', '!=', 'DIREKSI')->get();
        $client = Client::where('no_sambungan', $data->client_id)->first();
        return view('pages.transaction.work_order_form', compact([
            'title',
            'data',
            'types',
            'staff',
            'client',
        ]));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        // validasi
        $request->validate([
            'tgl_work_order' => 'required',
            'jenis_work_order' => 'required',
            'staff_id' => 'required',
        ], [
            'tgl_work_order.required' => 'Tanggal Work Order tidak boleh kosong',
            'jenis_work_order.required' => 'Jenis Work Order tidak boleh kosong',
            'staff_id.required' => 'Staff tidak boleh kosong',
        ]
        );
        // update data
        DB::beginTransaction();
        try {
            $workOrder = WorkOrder::findOrFail($id);
            $workOrder->tgl_work_order = Carbon::parse($request->tgl_work_order)->format('Y-m-d H:i:s');
            $workOrder->type_id = $request->jenis_work_order;
            $workOrder->staff_id = $request->staff_id;
            $workOrder->client_id = $request->client_id;
            $workOrder->document_id = $request->document_id;
            $workOrder->latitude = $request->latitude;
            $workOrder->longitude = $request->longitude;
            $workOrder->google_maps = $request->google_maps;
            $workOrder->deskripsi = $request->deskripsi;
            $workOrder->keterangan = $request->keterangan;
            $workOrder->save();
            DB::commit();
            return redirect()->route('work-order')->with('success', 'Data Work Order berhasil diubah');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data Work Order gagal diubah : ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        // proses hapus data
        DB::beginTransaction();
        try {
            $data = WorkOrder::findOrFail($id);
            $data->delete();
            DB::commit();
            return redirect()->route('work-order')->with('success', 'Data work order berhasil dihapus');
        } catch (\Throwable$th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data work order gagal dihapus : ' . $th->getMessage());
        }
    }
}
