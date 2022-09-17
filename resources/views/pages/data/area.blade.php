@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
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
            <div class="card-body p-0 table-responsive">
                <div class="header p-3">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('area') }}" class="btn btn-info"><i class="fa fa-sync-alt"> Refresh</i></a>
                            <a href="{{ route('area.create') }}" class="btn btn-primary"><i class="fa fa-plus"> Tambah
                                    Data</i></a>
                            {{-- <a href="{{ route('area.export') }}" class="btn btn-success"><i class="fa fa-file-excel">
                                    Export
                                    Excel</i></a>
                            <a href="{{ route('area.pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"> Export
                                    PDF</i></a>
                            <a href="{{ route('area.print') }}" class="btn btn-warning"><i class="fa fa-print">
                                    Print</i></a> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('area.search') }}" method="get">
                                <div class="form-group">
                                    <label for="no_sambungan">Cari kode area</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="uuid" class="form-control float-right"
                                            value="{{ app('request')->input('uuid') ?? '' }}" placeholder="Cari Kode Area"
                                            id="search-kode-area">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('area.search') }}" method="get">
                                <div class="form-group">
                                    <label for="nama">Cari Nama Area</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="name" class="form-control float-right"
                                            value="{{ app('request')->input('name') ?? '' }}" placeholder="Nama"
                                            id="search-nama-area">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <table class="table table-striped projects">
                    <thead>
                        <tr>
                            {{-- <th>
                                <input type="checkbox" id="checkbox">
                            </th> --}}
                            <th style="width: 1%">
                                No
                            </th>
                            <th>
                                Kode Area
                            </th>
                            <th style="width: 20%">
                                Nama Kecamatan
                            </th>
                            <th style="width: 20%">
                                Kode Wilayah
                            </th>
                            <th style="width: 20%">
                                Nama Jalan
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($areas as $key => $item)
                            <tr>
                                {{-- <th>
                                    <input type="checkbox" name="checkbox[]" data-id="{{ $item->id }}">
                                </th> --}}
                                <td>
                                    {{ $areas->firstItem() + $key }}
                                </td>
                                <td>
                                    <a>
                                        {{ $item->uuid }}
                                    </a>
                                    <br />
                                    <small>
                                        {{ $item->created_at }}
                                    </small>
                                </td>
                                <td>
                                    <a>
                                        {{ $item->nama_area }}
                                    </a>
                                    <br />
                                    <small>
                                        {{ $item->kode_area }}
                                    </small>
                                </td>
                                <td>
                                    {{ $item->kode_wilayah }}
                                    <br />
                                    {{-- <small>
                                        {{ $item->kode_kelurahan }}
                                    </small> --}}
                                </td>
                                <td>
                                    {{ $item->nama_jalan }}
                                    <br />
                                    <small>
                                        {{ $item->kode_jalan }}
                                    </small>
                                </td>
                                <td class="project-actions text-right">
                                    <a class="btn btn-info btn-sm" href="{{ route('area.edit', $item->uuid) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#"
                                        onclick="deleteConfirm('{{ $item->uuid }}', '{{ $item->uuid . ' ' . $item->nama_jalan }}')">
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
                        Menampilkan {{ $areas->firstItem() }} sampai {{ $areas->lastItem() }} dari total
                        {{ number_format($areas->total()) }} data
                    </p>
                    {{ $areas->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
@section('modal')
@endsection
@section('scripts')
    <script>
        $("#checkbox").click(function(e) {
            if ($(this).is(":checked")) {
                $("input[name='checkbox[]']").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $("input[name='checkbox[]']").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });

        function deleteConfirm(id, name) {
            console.log(id, name);
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Menghapus data " + name + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('areas') }}" + '/delete/' + id,
                        type: "POST",
                        data: {
                            '_token': "{{ csrf_token() }}"
                        },
                        success: function(data) {
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            )
                            location.reload();
                        },
                        error: function(data) {
                            console.log(data);
                            Swal.fire(
                                'Gagal!',
                                'Data gagal dihapus.',
                                'error'
                            )
                        }
                    });
                }
            })
        }
    </script>
@endsection
