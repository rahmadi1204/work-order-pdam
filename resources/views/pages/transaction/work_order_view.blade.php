@extends('layouts.app')
@section('content')
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Work Order Detail</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12">
                                <div class="post">
                                    <h4>Permintaan</h4>
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ asset('/images/avatar.png') }}"
                                            alt="user image">
                                        <span class="username">
                                            <a href="#">Admin</a>
                                        </span>
                                        <span class="description">{{ $data->tgl_work_order }}</span>
                                    </div>
                                    <!-- /.user-block -->
                                    <p>
                                        {{ $data->type->keterangan }}
                                    </p>
                                </div>
                                @if ($data->tgl_work_order_response != null)
                                    <div class="post clearfix">
                                        <h4>Dikerjakan</h4>
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm"
                                                src="{{ isset($data) && $data->staff->image != null ? asset('storage' . $data->image) : asset('/images/avatar.png') }}"
                                                alt="user image">
                                            <span class="username">
                                                <a href="#">{{ $data->staff->nama }}</a>
                                            </span>
                                            <span class="description">{{ $data->tgl_work_order_response }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            {{ $data->keterangan_petugas }}
                                        </p>
                                    </div>
                                @endif
                                @if ($data->tgl_work_order_done != null)
                                    <div class="post">
                                        <h4>Diselesaikan</h4>
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm"
                                                src="{{ isset($data) && $data->staff->image != null ? asset('storage' . $data->image) : asset('/images/avatar.png') }}"
                                                alt="user image">
                                            <span class="username">
                                                <a href="#">{{ $data->staff->nama }}</a>
                                            </span>
                                            <span class="description">{{ $data->tgl_work_order_done }}</span>
                                        </div>
                                        <!-- /.user-block -->
                                        <p>
                                            {{ $data->keterangan_selesai }}
                                        </p>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-4 order-1 order-md-2">
                        <ul class="list-unstyled">
                            @if ($data->google_maps != null)
                                <li>
                                    <a href="{{ $data->google_maps }}" class="btn-link text-secondary"><i
                                            class="fa fa-street-view"></i> Lihat Maps</a>
                                </li>
                            @endif
                            @if ($data->client_id != null)
                                <li>
                                    <i class="fas fa-user"></i> {{ $data->client->nama }}
                                </li>
                                <li>
                                    <i class="fas fa-home"></i> {{ $data->client->alamat }}
                                </li>
                            @endif
                        </ul>
                        {{-- <div class="text-center mt-5 mb-3">
                            <a href="#" class="btn btn-sm btn-primary">Add files</a>
                            <a href="#" class="btn btn-sm btn-warning">Report contact</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
@endsection
@section('scripts')
@endsection
