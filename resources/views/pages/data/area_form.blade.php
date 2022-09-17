@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container">
            <div class="callout callout-info">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Aturan Kode</h5>

                        <p>Kode wilayah = <b> contoh (1)</b> <br>
                            Kode kelurahan = Kode wilayah.angka <b> contoh (1.2)</b> <br>
                            Kode jalan = Kode kelurahan.angka <b> contoh (1.2.2)</b><br>
                        </p>
                    </div>
                    <div class="col-md-6">
                    </div>
                </div>
            </div>
            <form action="{{ isset($data) ? route('area.update', $data->uuid) : route('area.store') }}" method="post">
                @csrf
                <input type="hidden" name="uuid" value="{{ $data->uuid ?? '' }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Wilayah</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="data_area">Pilih Wilayah</label>
                                    <select name="data_area" id="data_area" class="form-control">
                                        <option value="">Pilih Wilayah</option>
                                        @foreach ($areas as $item)
                                            <option value="{{ $item->kode_area }}" data-name="{{ $item->nama_area }}">
                                                {{ $item->nama_area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kode_area">Kode Wilayah</label>
                                    <input type="text"name="kode_area" id="kode_area" class="form-control"
                                        value="{{ $data->kode_area ?? old('kode_area') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_area">Nama Wilayah</label>
                                    <input type="text" name="nama_area" id="nama_area" class="form-control"
                                        value="{{ $data->nama_area ?? old('nama_area') }}" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3 class="card-title">Kelurahan</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="data_kelurahan">Pilih Kelurahan</label>
                                    <select name="data_kelurahan" id="data_kelurahan" class="form-control">

                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kode_kelurahan">Kode Kelurahan</label>
                                    <input type="text" name="kode_kelurahan" id="kode_kelurahan"
                                        value="{{ $data->kode_kelurahan ?? old('kode_kelurahan') }}" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_kelurahan">Nama Kelurahan</label>
                                    <input type="text" name="nama_kelurahan" id="nama_kelurahan"
                                        value="{{ $data->nama_kelurahan ?? old('nama_kelurahan') }}" class="form-control"
                                        required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Jalan</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- <div class="form-group">
                                <label for="inputEstimatedBudget">Pilih Kelurahan</label>
                                <select name="kode_area" id="kode_area_kelurahan" class="form-control">
                                    @foreach ($districts as $item)
                                        <option value="{{ $item->kode_kelurahan }}">{{ $item->nama_kelurahan }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                                <div class="form-group">
                                    <label for="kode_jalan">Kode Jalan</label>
                                    <input type="text" name="kode_jalan" id="kode_jalan"
                                        value="{{ $data->kode_jalan ?? old('kode_jalan') }}" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_jalan">Nama Jalan</label>
                                    <input type="text" name="nama_jalan" id="nama_jalan"
                                        value="{{ $data->nama_jalan ?? old('nama_jalan') }}" class="form-control" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('area') }}" class="btn btn-secondary mx-1">Kembali</a>
                    <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                </div>
                {{-- <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Data Wilayah</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered table-striped" id="table-wilayah" style="width: 100%">
                                    <thead class=d">
                                        <tr>
                                            <th>Kode Wilayah</th>
                                            <th>Nama Wilayah</th>
                                            <th>Kode Kelurahan</th>
                                            <th>Nama Kelurahan</th>
                                            <th>Kode Jalan</th>
                                            <th>Nama Jalan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="data-jalan">

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div> --}}
            </form>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('#data_area').change(function(e) {
            e.preventDefault();
            let kode = $(this).val();
            let name = $(this).find(':selected').data('name');
            console.log(kode);
            console.log(name);
            $('#nama_area').val(name);
            $('#kode_area').val(kode);
            $('#nama_kelurahan').val('');
            $('#kode_kelurahan').val('');
            getKelurahan(kode);
        });

        function getKelurahan() {
            let kode = $('#data_area').val();
            $.ajax({
                url: "{{ route('area.kelurahan') }}",
                type: "GET",
                data: {
                    kode_area: kode
                },
                success: function(data) {
                    console.log(data);
                    $('#data_kelurahan').empty();
                    $('#data_kelurahan').append('<option value="">Pilih Kelurahan</option>');
                    $.each(data, function(key, value) {
                        $('#data_kelurahan').append(
                            `<option value="${value.kode_kelurahan}" data-name="${value.nama_kelurahan}">${value.nama_kelurahan}</option>`
                        );
                    });
                },
                error: function(err) {
                    console.log(err);
                    $('#data_kelurahan').empty();
                    $('#data_kelurahan').append('<option value="">Server Error</option>');
                }
            });
        }

        $('#data_kelurahan').change(function(e) {
            e.preventDefault();
            let kode = $(this).val();
            let name = $(this).find(':selected').data('name');
            console.log(kode);
            console.log(name);
            $('#nama_kelurahan').val(name);
            $('#kode_kelurahan').val(kode);
            $('#kode_jalan').val(kode + '.');
            $.ajax({
                type: "get",
                url: "{{ route('area.get') }}",
                data: {
                    kelurahan: kode
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('.data-jalan').empty();
                        $.each(response.data, function(indexInArray, valueOfElement) {
                            $('.data-jalan').append(`
                                <tr>
                                    <td>${valueOfElement.kode_area}</td>
                                    <td>${valueOfElement.nama_area}</td>
                                    <td>${valueOfElement.kode_kelurahan}</td>
                                    <td>${valueOfElement.nama_kelurahan}</td>
                                    <td>${valueOfElement.kode_jalan}</td>
                                    <td>${valueOfElement.nama_jalan}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('.data-jalan').empty();
                        $('.data-jalan').append(`
                            <tr>
                                <td colspan="6" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        `);
                    }
                },
                error: function(response) {
                    console.log(response);
                    $('.data-jalan').empty();
                    $('.data-jalan').append(`
                            <tr>
                                <td colspan="6" class="text-center">Server Error</td>
                            </tr>
                        `);
                }
            });
        });

        $('#table-wilayah').DataTable({
            "scrollX": true,
            "scrollY": "300px",
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": true,
            "responsive": false,
        });
    </script>
@endsection
