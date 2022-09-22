<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Data\Client;
use App\Models\Transaction\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderResponseController extends Controller
{
    public function index()
    {
        $title = 'Work Order';
        $filter = 'proses';
        return view('pages.transaction.work_order', compact([
            'title',
            'filter',
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
            $query->whereBetween('tgl_work_order_response', [$start_date, $end_date]);
        }
        if (auth()->user()->role == 'user') {
            $query = $query->where('staff_id', auth()->user()->staff->kode_jabatan);
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
                return Carbon::parse($data->tgl_work_order_response)->format('Y M d') ?? '-';
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
                $action .= '<a href="' . url('work-order/response/edit', $data->uuid) . '" class="btn btn-info mx-1"><i class="fas fa-pencil-alt"></i>Selesaikan</a>';
                $action .= '<a href="#" onclick="deleteConfirm(' . $data->id . ',`' . $data->nama . '`)" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i>Batalkan</a>';
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['checkbox', 'type_id', 'staff_id', 'status_work_order', 'action'])
            ->make(true);
    }
    public function edit($id)
    {
        $title = 'Work Order';
        $data = WorkOrder::with([
            'staff' => function ($query) {
                $query->select('kode_jabatan', 'nama', 'kategori_jabatan');
            },
            'type' => function ($query) {
                $query->select('kode_work_order', 'jenis_work_order');
            },
        ])->where('uuid', $id)->first();
        $client = Client::with('area')->where('no_sambungan', $data->client_id)->first();
        $response = true;
        $path = 'storage/';
        return view('pages.transaction.work_order_request_form', compact([
            'title',
            'data',
            'client',
            'response',
            'path',
        ]));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $validate = $request->validate([
            'tgl_work_order_done' => 'required',
            'keterangan_selesai' => 'required',
        ], [
            'tgl_work_order_done.required' => 'Tanggal Selesai WO harus diisi',
            'keterangan_selesai.required' => 'Keterangan harus diisi',
        ]);
        DB::beginTransaction();
        try {
            $data = WorkOrder::find($id);
            $data->tgl_work_order_done = $request->tgl_work_order_done;
            $data->keterangan_selesai = $request->keterangan_selesai;
            $data->updated_by = auth()->user()->name;
            $data->status_work_order = 'selesai';
            $data->save();
            DB::commit();
            return redirect()->route('work-order.response')->with('success', 'Data berhasil diubah');
        } catch (\Exception$e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Data gagal diubah');
        }
    }
}
