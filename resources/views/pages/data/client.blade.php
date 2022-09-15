@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3>Data Pelanggan</h3>
                </div>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0 table-responsive">
                <div class="header p-3">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('client') }}" class="btn btn-info"><i class="fa fa-sync-alt"> Refresh</i></a>
                            <a href="{{ route('client.create') }}" class="btn btn-primary"><i class="fa fa-plus"> Tambah
                                    Data</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('client.search') }}" method="get">
                                <div class="form-group">
                                    <label for="no_sambungan">Cari No Pelanggan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="number" name="no_pelanggan" class="form-control float-right"
                                            value="{{ app('request')->input('no_pelanggan') ?? '' }}"
                                            placeholder="Cari No Pelanggan" id="search-no-pelanggan">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('client.search') }}" method="get">
                                <div class="form-group">
                                    <label for="nama">Cari Nama Pelanggan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="name" class="form-control float-right"
                                            value="{{ app('request')->input('name') ?? '' }}" placeholder="Nama"
                                            id="search-nama-pelanggan">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('client.search') }}" method="get">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="alamat" class="form-control float-right"
                                            value="{{ app('request')->input('alamat') ?? '' }}" placeholder="Alamat"
                                            id="search-alamat">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter">Filter
                                </label>
                                <select name="filter" id="filterActive" class="form-control">
                                    <option value="all"
                                        @if (!isset($_GET['status'])) @else
                                        selected @endif>
                                        Semua</option>
                                    <option value="1" {{ app('request')->input('status') == '1' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="0" {{ app('request')->input('status') == '0' ? 'selected' : '' }}>
                                        Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                No
                            </th>
                            <th style="width: 10%">
                                No Pelanggan
                            </th>
                            <th style="width: 20%">
                                Nama
                            </th>
                            <th>
                                Alamat
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $key => $item)
                            <tr>
                                <td>
                                    {{ $clients->firstItem() + $key }}
                                </td>
                                <td>
                                    <a>
                                        {{ $item->no_sambungan }}
                                    </a>
                                    <br />
                                    <small>
                                        {{ $item->created_at }}
                                    </small>
                                </td>
                                <td>
                                    <a>
                                        {{ $item->name }}
                                    </a>
                                    <br />
                                    <small>
                                        {{ $item->id_pelanggan }}
                                    </small>
                                </td>
                                <td class="project_progress">
                                    {{ $item->alamat }}
                                    <br />
                                    <small>
                                        {{ $item->wilayah->name ?? '' }}
                                    </small>
                                </td>
                                <td class="project-state">
                                    @if ($item->is_active == 1)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-danger">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a>
                                    <a class="btn btn-info btn-sm" href="#">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between m-2">
                    <p>
                        Menampilkan {{ $clients->firstItem() }} sampai {{ $clients->lastItem() }} dari total
                        {{ number_format($clients->total()) }} data
                    </p>
                    {{ $clients->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
    {{-- <a href="{{ route('client.export') }}" class="btn btn-success"><i class="fa fa-file-excel">
                                    Export
                                    Excel</i></a>
                            <a href="{{ route('client.pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"> Export
                                    PDF</i></a>
                            <a href="{{ route('client.print') }}" class="btn btn-warning"><i class="fa fa-print">
                                    Print</i></a> --}}
@endsection
@section('modal')
@endsection
@section('scripts')
    <script>
        $('#filterActive').change(function(e) {
            e.preventDefault();
            var filter = $(this).val();
            var url = "{{ route('client.filter') }}";
            if (filter == 'all') {
                window.location = url;
            } else {
                window.location = url + "?status=" + filter;
            }
        });
    </script>
@endsection
