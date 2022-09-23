<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Transaction\WorkOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderRealizationController extends Controller
{
    public function index()
    {
        $title = 'Realisasi Surat Perintah Kerja';
        $filter = 'selesai';
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
        if ($request->status != null) {
            $query->whereIn('status_work_order', $request->status);
        }
        if ($request->date != null) {
            $start_date = substr($request->date, 0, 10);
            $end_date = substr($request->date, 13, 10);
            $query->whereBetween('tgl_work_order_done', [$start_date, $end_date]);
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
                return Carbon::parse($data->tgl_work_order_done)->format('Y M d') ?? '-';
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
                $action .= '<a href="' . url('work-order/view', $data->uuid) . '" class="btn btn-success mx-1"><i class="fas fa-eye"></i>View</a>';
                if ($data->status_work_order == 'cancel') {
                    $action .= '<a href="#" class="btn btn-secondary mx-1"><i class="fas fa-trash-alt"></i>Batalkan</a>';
                } else {
                    $action .= '<a href="#" onclick="cancelConfirm(' . $data->id . ',`' . $data->type->jenis_work_order . '`)" class="btn btn-danger mx-1"><i class="fas fa-trash-alt"></i>Batalkan</a>';
                }
                $action .= '</div>';
                return $action;
            })
            ->rawColumns(['checkbox', 'type_id', 'staff_id', 'status_work_order', 'action'])
            ->make(true);
    }
}
