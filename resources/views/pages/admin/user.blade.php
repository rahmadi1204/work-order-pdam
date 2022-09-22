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
                            <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus">
                                    Tambah
                                    Data</i></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="role">Cari Role</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="role" class="form-control float-right"
                                        placeholder="Cari Kode Work Order" id="search-role">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Cari Nama</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-info search"><i
                                                class="fa fa-search"></i></button>
                                    </div>
                                    <input type="text" name="name" class="form-control float-right"
                                        placeholder="Cari Nama" id="search-name">
                                </div>
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
                            <th style="width: 30%">
                                Nama
                            </th>
                            <th>
                                Username
                            </th>
                            <th>
                                Role
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Last Seen
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
    @include('pages.admin.user_script')
@endsection
