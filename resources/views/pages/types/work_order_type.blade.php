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
                            <a href="{{ route('type.work-order.create') }}" class="btn btn-primary"><i class="fa fa-plus">
                                    Tambah
                                    Data</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="kode_work_order">Cari Kode Work Order</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="kode_work_order" class="form-control float-right"
                                        placeholder="Cari Kode Work Order" id="search-kode-work-order">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="jenis_work_order">Cari Jenis Work Order</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="jenis_work_order" class="form-control float-right"
                                        placeholder="Cari Jenis Work Order" id="search-jenis-work-order">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="responder">Cari Responder</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="responder" class="form-control float-right"
                                        placeholder="Cari Responder" id="search-responder">
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="start_date">Tanggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-info">
                                        <i class="far fa-calendar-alt"></i>
                                    </span>
                                </div>
                                <input type="text" name="date" class="form-control float-right" id="reservation"
                                    value="{{ now()->startOfMonth()->format('Y-m-d') .' - ' .now()->endOfMonth()->format('Y-m-d') }}">
                            </div>
                        </div>
                    </div> --}}
                </div>
                <table class="table table-striped" id="datatable">
                    <thead>
                        <tr>
                            <th style="width: 1%">
                                No
                            </th>
                            <th style="width: 15%">
                                Kode
                            </th>
                            <th>
                                Jenis
                            </th>
                            <th>
                                PTS
                            </th>
                            <th style="width: 20%">
                                Responder
                            </th>
                            <th style="width: 20%">
                                Keterangan
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
    @include('pages.types.work_order_type_script')
@endsection
