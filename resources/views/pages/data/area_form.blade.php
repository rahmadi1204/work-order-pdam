@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container">
            <div class="callout callout-info">
                {{-- <div class="row">
                    <div class="col-12">
                        <h5>Aturan Kode</h5>

                        <p>
                            Tambahkan 0 bila angka 1 digit.<br>
                            Contoh : 01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12, 13,
                            14,15, 16, 17, 18, 19, 20, dst.
                        </p>
                    </div>
                </div> --}}
            </div>
            <form action="{{ isset($data) ? route('area.update', $data->id) : route('area.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
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
                                    @if (isset($data))
                                        <input type="hidden" name="data_area" id="data_area" class="form-control"
                                            value="{{ $data->kode_area }}">
                                    @else
                                        <label for="data_area">Pilih Area</label>
                                        <select name="data_area" id="data_area" class="form-control">
                                            <option value="">Pilih Area</option>
                                            @foreach ($areas as $item)
                                                <option value="{{ $item->kode_area }}"
                                                    {{ old('data_area') == $item->kode_area ? 'selected' : '' }}
                                                    {{ isset($data) && $data->kode_area == $item->kode_area ? 'selected' : '' }}
                                                    data-name="{{ $item->nama_area }}">
                                                    {{ $item->nama_area }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="kode_area">Kode Area</label>
                                    <input type="number"name="kode_area" id="kode_area" class="form-control"
                                        value="{{ $data->kode_area ?? old('kode_area') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_area">Nama Area</label>
                                    <input type="text" name="nama_area" id="nama_area" class="form-control"
                                        value="{{ $data->nama_area ?? old('nama_area') }}" required>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-md-6">
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
                                <div class="form-group">
                                    <label for="kode_wilayah">Kode Wilayah</label>
                                    {{-- <select name="kode_area_wilayah" id="kode_area_wilayah" class="form-control mb-2">
                                        <option value="">Pilih Wilayah</option>
                                    </select> --}}
                                    <input type="number" name="kode_wilayah" id="kode_wilayah"
                                        value="{{ $data->kode_wilayah ?? old('kode_wilayah') }}" class="form-control"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="kode_jalan">Kode Jalan</label>
                                    <input type="number" name="kode_jalan" id="kode_jalan"
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
                {{-- show list data jalan --}}
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
                                            <th>Kode Kecamatan</th>
                                            <th>Nama Kecamatan</th>
                                            <th>Kode Wilayah</th>
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
        let kodeArea = $('#kode_area').val();
        if (kodeArea.length > 0) {
            getWilayah(kodeArea);
        }
        let KodeWilayah = $('#kode_wilayah').val();
        if (KodeWilayah.length > 0) {
            getJalan(KodeWilayah);
        }
        $('#data_area').change(function(e) {
            e.preventDefault();
            let kode = $(this).val();
            let name = $(this).find(':selected').data('name');
            $('#nama_area').val(name);
            $('#kode_area').val(kode);
            $('#kode_wilayah').val('');
            $('#kode_jalan').val('');
            $('#nama_jalan').val('');
            getWilayah(kode);
        });
        $('#kode_area_wilayah').change(function(e) {
            e.preventDefault();
            let kode = $(this).val();
            $('#kode_jalan').focus();
            $('#kode_wilayah').val(kode);
            $('#nama_jalan').val('');
            getJalan(kode);
        });

        function getWilayah(kode) {
            $.ajax({
                url: "{{ route('area.wilayah') }}",
                type: "GET",
                data: {
                    kode_area: kode
                },
                success: function(data) {
                    console.log(data);
                    $('#kode_area_wilayah').empty();
                    $('#kode_area_wilayah').append('<option value="">Pilih Wilayah</option>');
                    $.each(data, function(key, value) {
                        $('#kode_area_wilayah').append(
                            `<option value="${value.kode_wilayah}" >${value.kode_wilayah}</option>`
                        );
                    });
                },
                error: function(err) {
                    console.log(err);
                    $('#kode_area_wilayah').empty();
                    $('#kode_area_wilayah').append('<option value="">Server Error</option>');
                }
            });
        }

        function getJalan(kode) {
            $.ajax({
                type: "get",
                url: "{{ route('area.get') }}",
                data: {
                    kode_wilayah: kode
                },
                success: function(response) {
                    if (response.status == 'success') {
                        $('.data-jalan').empty();
                        $.each(response.data, function(indexInArray, valueOfElement) {
                            $('.data-jalan').append(`
                                <tr>
                                    <td>${valueOfElement.kode_area}</td>
                                    <td>${valueOfElement.nama_area}</td>
                                    <td>${valueOfElement.kode_wilayah}</td>
                                    <td>${valueOfElement.kode_jalan}</td>
                                    <td>${valueOfElement.nama_jalan}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('.data-jalan').empty();
                        $('.data-jalan').append(`
                            <tr>
                                <td colspan="5" class="text-center">Data Tidak Ditemukan</td>
                            </tr>
                        `);
                    }
                },
                error: function(response) {
                    console.log(response);
                    $('.data-jalan').empty();
                    $('.data-jalan').append(`
                            <tr>
                                <td colspan="5" class="text-center">Server Error</td>
                            </tr>
                        `);
                }
            });
        }

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
