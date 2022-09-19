@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">
                    <h3>{{ $title }}</h3>
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
            <div class="card-body table-responsive">
                <div class="header">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="#" class="btn btn-info refresh"><i class="fa fa-sync-alt"> Refresh</i></a>
                            <a href="{{ route('work-order.create') }}" class="btn btn-primary"><i class="fa fa-plus"> Tambah
                                    Data</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type_id">Cari Kode Work Order</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="number" name="type_id" class="form-control float-right"
                                        placeholder="Cari No Sambungan" id="search-no-sambungan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nama">Cari Nama Petugas</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="name" class="form-control float-right" placeholder="Nama"
                                        id="search-nama-pelanggan">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="alamat"
                                        class="form-control float-right"placeholder="Alamat" id="search-alamat">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="filter">Filter
                                </label>
                                <select name="status" id="filterActive" class="form-control">
                                    <option value="all">Semua</option>
                                    <option value="pending">Pending</option>
                                    <option value="proses">Proses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="start_date">Tanggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="reservation"
                                    value="{{ '2011-01-01 - ' .now()->endOfMonth()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                No
                            </th>
                            <th>
                                Tanggal
                            </th>
                            <th style="width: 15%">
                                Kode Work Order
                            </th>
                            <th style="width: 20%">
                                Nama Petugas
                            </th>
                            <th>
                                Pelanggan
                            </th>
                            <th style="width: 8%" class="text-center">
                                Status
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <div class="container">
        <br>
    </div>
    <!-- /.content -->
@endsection
@section('modal')
@endsection
@section('scripts')
    @include('pages.transaction.work_order_script')
@endsection
