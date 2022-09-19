@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <form action="{{ isset($data) ? route('client.update', $data->id) : route('client.store') }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ isset($data) && $data->image != null ? asset('storage' . $data->image) : asset('/images/avatar.png') }}"
                                        id="image" alt="User profile picture">
                                </div>
                                @isset($data)
                                    <h3 class="profile-username text-center">{{ $data->nama }}</h3>

                                    <p class="text-muted text-center">{{ $data->id_pelanggan }}</p>
                                @endisset

                                <ul class="list-group list-group-unbordered mb-3">
                                    @isset($data)
                                        <li class="list-group-item">
                                            <b>No Sambungan</b> <a class="float-right">{{ $data->no_sambungan }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Alamat</b> <a class="float-right">{{ $data->alamat }}</a>
                                        </li>
                                    @endisset
                                    <li class="list-group-item">
                                        <b>Upload Foto</b> <input type="file" name="image" class="form-control"
                                            id="uploadImage" accept="image/*">
                                    </li>
                                </ul>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link" href="#data" data-toggle="tab">Data</a></li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="data">
                                        <form class="form-horizontal">
                                            <div class="form-group row">
                                                <label for="tgl_masuk" class="col-sm-2 col-form-label">Tanggal
                                                    Masuk<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <div class="input-group date" id="datepicker"
                                                        data-target-input="nearest">
                                                        <input type="text" name="tgl_masuk"
                                                            class="form-control datetimepicker-input"
                                                            value="{{ isset($data) ? $data->tgl_masuk : old('tgl_masuk') }}"
                                                            data-target="#datepicker" required>
                                                        <div class="input-group-append" data-target="#datepicker"
                                                            data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="name"
                                                    class="col-sm-2 col-form-label">Nama<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama" class="form-control" id="nama"
                                                        value="{{ $data->nama ?? old('nama') }}" placeholder="Nama"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-sm-2 col-form-label">
                                                    Kelurahan<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <select name="id_kelurahan" id="kelurahan" class="form-control select2">
                                                        <option value="">-- Pilih Kelurahan --</option>
                                                        @foreach ($kelurahans as $item)
                                                            <option value="{{ $item->uuid }}"
                                                                {{ isset($data) && $data->id_kelurahan == $item->uuid ? 'selected' : '' }}
                                                                {{ old('id_kelurahan') == $item->uuid ? 'selected' : '' }}
                                                                data-id="{{ str_replace(['KEL-', '.'], '', $item->uuid) }}">
                                                                {{ 'KEC. ' . $item->nama_kecamatan . ' - ' . $item->nama_kelurahan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-sm-2 col-form-label">
                                                    Area<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <select name="id_area" id="area" class="form-control select2">
                                                        <option value="">-- Pilih Area --</option>
                                                        @foreach ($areas as $item)
                                                            <option value="{{ $item->uuid }}"
                                                                {{ isset($data) && $data->id_area == $item->uuid ? 'selected' : '' }}
                                                                {{ old('id_area') == $item->uuid ? 'selected' : '' }}
                                                                data-id="{{ str_replace(['AREA-', '.'], '', $item->uuid) }}">
                                                                {{ $item->nama_jalan . ' | Kode : ' . str_replace(['AREA-'], '', $item->uuid) }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="id_pelanggan" class="col-sm-2 col-form-label">No
                                                    Sambungan<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="no_sambungan" class="form-control"
                                                        id="no_sambungan"
                                                        value="{{ $data->no_sambungan ?? old('no_sambungan') }}"
                                                        placeholder="No Sambungan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-sm-2 col-form-label">
                                                    Nomor Urut<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="no_urut" class="form-control"
                                                        id="no_urut" value="{{ $data->no_urut ?? old('no_urut') }}"
                                                        placeholder="Nomor Urut" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="id_pelanggan" class="col-sm-2 col-form-label">ID
                                                    Pelanggan<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="id_pelanggan"
                                                        class="form-control id-pelanggan" id="id_pelanggan"
                                                        value="{{ $data->id_pelanggan ?? old('id_pelanggan') }}"
                                                        placeholder="ID Pelanggan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="no_telpon" class="col-sm-2 col-form-label">No Telp</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="no_telpon" class="form-control telp"
                                                        data-mask="(000) 000-000-000" id="no_telpon"
                                                        value="{{ $data->no_telpon ?? old('no_telpon') }}"
                                                        placeholder="Nomor Telepon">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="no_hp" class="col-sm-2 col-form-label">No HP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="no_hp" class="form-control hp"
                                                        data-mask="0000-0000-00000" id="no_hp"
                                                        value="{{ $data->no_hp ?? old('no_hp') }}"
                                                        placeholder="Nomor HP">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="alamat"
                                                    class="col-sm-2 col-form-label">Alamat<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="alamat" class="form-control"
                                                        id="alamat" value="{{ $data->alamat ?? old('alamat') }}"
                                                        placeholder="Alamat" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-sm-2 col-form-label">
                                                    Koordinat</label>
                                                <div class="col-sm-10">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" name="latitude" class="form-control"
                                                            value="{{ $data->latitude ?? old('latitude') }}"
                                                            placeholder="Latitude" id="latitude">
                                                        <input type="text" name="longitude" class="form-control"
                                                            value="{{ $data->longitude ?? old('longitude') }}"
                                                            placeholder="Longitude" id="longitude">
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat"
                                                                onclick="getKoordinate()">Get!</button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status" class="col-sm-2 col-form-label">Status</label>
                                                <div class="col-10">
                                                    <input type="checkbox" name="is_active" checked data-bootstrap-switch
                                                        data-off-color="danger" data-on-color="success">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <a href="{{ route('client') }}" class="btn btn-secondary">Kembali</a>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
@endsection
@section('modal')
@endsection
@section('scripts')
    <script>
        $('#uploadImage').change(function(e) {
            e.preventDefault();
            var file = this.files[0];
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        });
        $("input[data-bootstrap-switch]").each(function() {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        })
    </script>
    <script>
        function getKoordinate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                alert("Failed to get location");
                console.log('Failed to get location');
            }
        }

        function showPosition(position) {
            console.log(position);
            $('#latitude').val(position.coords.latitude);
            $('#longitude').val(position.coords.longitude);
        }
    </script>
    {{-- create id pelanggan otomatis --}}
    <script>
        $('#area').change(function(e) {
            e.preventDefault();
            let id = $('#area option:selected').data('id');
            createID(id);
        });

        function createID(id) {
            let no_urut = $('#no_urut').val();
            let id_pelanggan = id + no_urut;
            $.ajax({
                type: "get",
                url: "{{ route('client.check') }}",
                data: {
                    id_pelanggan: id
                },
                success: function(response) {
                    $('#id_pelanggan').val(response.data);
                    $('#no_urut').val(response.no_urut);
                    $('#no_sambungan').val(response.no_sambungan);
                }
            });

        }
    </script>
@endsection
