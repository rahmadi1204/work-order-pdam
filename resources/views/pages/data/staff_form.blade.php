@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <form action="{{ isset($data) ? route('staff.update', $data->id) : route('staff.store') }}" method="post"
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

                                    <p class="text-muted text-center">{{ $data->jabatan }}</p>
                                @endisset

                                <ul class="list-group list-group-unbordered mb-3">
                                    @isset($data)
                                        <li class="list-group-item">
                                            <b>NIP</b> <a class="float-right">{{ $data->nip }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Golongan</b> <a class="float-right">{{ $data->golongan }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Jenjang</b> <a class="float-right">{{ $data->jenjang }}</a>
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
                                                <label for="name"
                                                    class="col-sm-2 col-form-label">Nama<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama" class="form-control" id="name"
                                                        value="{{ $data->nama ?? old('nama') }}" placeholder="Name"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kode_jabatan" class="col-sm-2 col-form-label">Kode
                                                    Jabatan<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="kode_jabatan" class="form-control"
                                                        id="kode_jabatan"
                                                        value="{{ $data->kode_jabatan ?? old('kode_jabatan') }}"
                                                        placeholder="Kode Jabatan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-sm-2 col-form-label">Kategori
                                                    Jabatan<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="kategori_jabatan" class="form-control"
                                                        id="kategori_jabatan"
                                                        value="{{ $data->kategori_jabatan ?? old('kategori_jabatan') }}"
                                                        placeholder="Kategori Jabatan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kategori" class="col-sm-2 col-form-label">
                                                    Jabatan<code>*</code></label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="jabatan" class="form-control" id="jabatan"
                                                        value="{{ $data->jabatan ?? old('jabatan') }}"
                                                        placeholder="Kategori Jabatan" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nip" class="form-control" id="nip"
                                                        value="{{ $data->nip ?? old('nip') }}" placeholder="NIP">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="ruang" class="col-sm-2 col-form-label">Ruang</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="ruang" class="form-control" id="ruang"
                                                        value="{{ $data->ruang ?? old('ruang') }}" placeholder="Ruang">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="golongan" class="col-sm-2 col-form-label">Golongan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="golongan" class="form-control"
                                                        id="golongan" value="{{ $data->golongan ?? old('golongan') }}"
                                                        placeholder="Golongan">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="jenjang" class="form-control"
                                                        id="jenjang" value="{{ $data->jenjang ?? old('jenjang') }}"
                                                        placeholder="Jenjang">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="status" class="col-sm-2 col-form-label">Status
                                                    Jabatan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="status" class="form-control"
                                                        id="status" value="{{ $data->status ?? old('status') }}"
                                                        placeholder="Status Jabatan">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <a href="{{ route('staff') }}" class="btn btn-secondary">Kembali</a>
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
    </script>
@endsection
