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
                            <a href="{{ route('staff') }}" class="btn btn-info"><i class="fa fa-sync-alt"> Refresh</i></a>
                            <a href="{{ route('staff.create') }}" class="btn btn-primary"><i class="fa fa-plus"> Tambah
                                    Data</i></a>
                            <a href="#" class="btn btn-success" id="btn-export"><i class="fa fa-file-excel">
                                    Export
                                    Excel</i></a>
                            {{-- <a href="{{ route('staff.pdf') }}" class="btn btn-danger"><i class="fa fa-file-pdf"> Export
                                    PDF</i></a>
                            <a href="{{ route('staff.print') }}" class="btn btn-warning"><i class="fa fa-print">
                                    Print</i></a> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <form action="{{ route('staff.search') }}" method="get">
                                <div class="form-group">
                                    <label for="no_sambungan">Cari kode jabatan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="kode_jabatan" class="form-control float-right"
                                            value="{{ app('request')->input('kode_jabatan') ?? '' }}"
                                            placeholder="Cari No jabatan" id="search-kode-jabatan">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('staff.search') }}" method="get">
                                <div class="form-group">
                                    <label for="no_sambungan">Cari NIP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="nip" class="form-control float-right"
                                            value="{{ app('request')->input('nip') ?? '' }}" placeholder="Cari NIP"
                                            id="search-nip">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('staff.search') }}" method="get">
                                <div class="form-group">
                                    <label for="nama">Cari Nama Karyawan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="name" class="form-control float-right"
                                            value="{{ app('request')->input('name') ?? '' }}" placeholder="Nama"
                                            id="search-nama-karyawan">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('staff.search') }}" method="get">
                                <div class="form-group">
                                    <label for="alamat">Jabatan</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-success"><i
                                                    class="fa fa-search"></i></button>
                                        </div>
                                        <input type="text" name="jabatan" class="form-control float-right"
                                            value="{{ app('request')->input('jabatan') ?? '' }}" placeholder="Jabatan"
                                            id="search-jabatan">
                                    </div>
                                </div>
                            </form>
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
                                Kode Jabatan
                            </th>
                            <th style="width: 20%">
                                Nama
                            </th>
                            <th>
                                Jabatan
                            </th>
                            <th>
                                Ruangan
                            </th>
                            <th style="width: 8%" class="text-center">
                                Golongan
                            </th>
                            <th style="width: 20%">
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($staffs as $key => $item)
                            <tr>
                                <td>
                                    {{ $staffs->firstItem() + $key }}
                                </td>
                                <td>
                                    <a>
                                        {{ $item->kode_jabatan }}
                                    </a>
                                </td>
                                <td>
                                    <a>
                                        {{ $item->nama }}
                                    </a>
                                    <br />
                                    <small>
                                        {{ $item->nip != null ? 'NIP : ' . $item->nip : '' }}
                                    </small>
                                </td>
                                <td>
                                    {{ $item->jabatan }}
                                    <br />
                                    <small>
                                        {{ $item->kategori_jabatan }}
                                    </small>
                                </td>
                                <td>
                                    {{ $item->ruang }}
                                </td>
                                <td>
                                    {{ $item->golongan }}
                                </td>
                                <td class="project-actions text-right">
                                    {{-- <a class="btn btn-primary btn-sm" href="#">
                                        <i class="fas fa-folder">
                                        </i>
                                        View
                                    </a> --}}
                                    <a class="btn btn-info btn-sm" href="{{ route('staff.edit', $item->uuid) }}">
                                        <i class="fas fa-pencil-alt">
                                        </i>
                                        Edit
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="#"
                                        onclick="deleteConfirm('{{ $item->id }}', '{{ $item->nama }}')">
                                        <i class="fas fa-trash">
                                        </i>
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Data Kosong
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-between m-2">
                    <p>
                        Menampilkan {{ $staffs->firstItem() }} sampai {{ $staffs->lastItem() }} dari total
                        {{ number_format($staffs->total()) }} data
                    </p>
                    {{ $staffs->links('pagination::bootstrap-4') }}
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
                        url: "{{ url('staffs') }}" + '/delete/' + id,
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
        $('#btn-export').click(function(e) {
            e.preventDefault();
            var kodeJabatan = $('#search-kode-jabatan').val();
            var nama = $('#search-nama-karyawan').val();
            var nip = $('#search-nip').val();
            var jabatan = $('#search-jabatan').val();
            var url = "{{ route('staff.export') }}" + '?kode_jabatan=' + kodeJabatan + '&name=' + nama + '&nip=' +
                nip + '&jabatan=' + jabatan;
            console.log(url);
            window.location.href = url;


        });
    </script>
@endsection
