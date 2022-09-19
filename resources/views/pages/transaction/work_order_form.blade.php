@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container">
            <form action="{{ isset($data) ? route('work-order.update', $data->id) : route('work-order.store') }}"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Work order</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_work_order">Tanggal Work Order<code>*</code></label>
                                    <div class="input-group date" id="datepicker" data-target-input="nearest">
                                        <input type="text" name="tgl_work_order"
                                            class="form-control datetimepicker-input"
                                            value="{{ isset($data) ? $data->tgl_work_order : old('tgl_work_order') }}"
                                            data-target="#datepicker" required>
                                        <div class="input-group-append" data-target="#datepicker"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_work_order">Jenis Work Order<code>*</code></label>
                                    <select name="jenis_work_order" id="jenis_work_order" class="form-control">
                                        <option value="">-- Pilih Jenis Work Order --</option>
                                        @forelse ($types as $item)
                                            <option value="{{ $item->kode_work_order }}"
                                                data-responder="{{ $item->responder }}"
                                                data-keterangan="{{ $item->keterangan }}"
                                                {{ isset($data) && $data->kode_work_order == $item->type_id ? 'selected' : '' }}>
                                                {{ $item->jenis_work_order }}</option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_jabatan">Unit Petugas<code>*</code></label>
                                    <input type="text" name="kategori_jabatan" id="kategori_jabatan" class="form-control"
                                        readonly>
                                </div>
                                <div class="form-group">
                                    <label for="staff_id">Petugas<code>*</code></label>
                                    <select name="staff_id" id="staff_id" class="form-control select2">
                                        <option value="">-- Pilih Petugas --</option>
                                        @forelse ($staff as $item)
                                            <option value="{{ $item->kode_jabatan }}"
                                                {{ isset($data) && $data->staff_id == $item->kode_jabatan ? 'selected' : '' }}
                                                {{ old('staff_id') == $item->kode_jabatan ? 'selected' : '' }}>
                                                {{ $item->nama }} <sub>{{ $item->golongan }}</sub></option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" placeholder="Enter ...">{{ $data->deskripsi ?? old('deskripsi') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-danger">
                            <div class="card-header">
                                <h3 class="card-title">Detail</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="client_id">Pelanggan<code>*</code></label>
                                    <select name="client_id" id="client_id" class="form-control select2">
                                        @isset($client)
                                            <option value="{{ $client->no_sambungan }}" selected>{{ $client->nama }}</option>
                                        @endisset
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat<code>*</code></label>
                                    <input type="text" name="alamat" id="alamat" class="form-control"
                                        value="{{ $client->alamat ?? '' }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="kategori">
                                        Koordinat</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="latitude" class="form-control"
                                            value="{{ $data->latitude ?? old('latitude') }}" placeholder="Latitude"
                                            id="latitude">
                                        <input type="text" name="longitude" class="form-control"
                                            value="{{ $data->longitude ?? old('longitude') }}" placeholder="Longitude"
                                            id="longitude">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat"
                                                onclick="getKoordinate()">Get!</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="google_maps">Link Google Maps</label>
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="google_maps" class="form-control"
                                            value="{{ $data->google_maps ?? old('google_maps') }}"
                                            placeholder="Link Google Maps" id="google_maps">
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-info btn-flat"
                                                onclick="getGoogleMaps()"><i class="fa fa-street-view"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Enter ...">{{ $data->keterangan ?? old('keterangan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary mx-1">Kembali</a>
                            <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('#jenis_work_order').change(function(e) {
            e.preventDefault();
            let filter = $(this).find(':selected').data('responder');
            let keterangan = $(this).find(':selected').data('keterangan');
            let identifier = 'kategori_jabatan';
            $('#kategori_jabatan').val(filter);
            $('#keterangan').val(keterangan);
            $.ajax({
                type: "GET",
                url: "{{ route('staff.filter') }}",
                data: {
                    filter: filter,
                    identifier: identifier
                },
                dataType: "JSON",
                success: function(response) {
                    let html = '';
                    if (response.length > 0) {
                        response.forEach(element => {
                            html +=
                                `<option value="${element.kode_jabatan}">${element.nama} <sub></sub></option>`;
                        });
                    } else {
                        html += `<option value="">Tidak ada data</option>`;
                    }
                    $('#staff_id').html(html);
                }
            });
        });
        $('#jenis_work_order option:selected').each(function() {
            let filter = $(this).data('responder');
            let keterangan = $(this).data('keterangan');
            let identifier = 'kategori_jabatan';
            $('#kategori_jabatan').val(filter);
            $('#keterangan').val(keterangan);
            $.ajax({
                type: "GET",
                url: "{{ route('staff.filter') }}",
                data: {
                    filter: filter,
                    identifier: identifier
                },
                dataType: "JSON",
                success: function(response) {
                    let html = '';
                    if (response.length > 0) {
                        response.forEach(element => {
                            html +=
                                `<option value="${element.kode_jabatan}">${element.nama} <sub></sub></option>`;
                        });
                    } else {
                        html += `<option value="">Tidak ada data</option>`;
                    }
                    $('#staff_id').html(html);
                }
            });
        });
        $(document).ready(function() {
            $("#client_id").select2({
                placeholder: "-- Pilih Pelanggan --",
                allowClear: true,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ route('client.select') }}",
                    dataType: 'json',
                    data: (params) => {
                        return {
                            q: params.term,
                        }
                    },
                    processResults: (data, params) => {
                        console.log(data)
                        const results = data.map(item => {
                            $('#alamat').val(item.alamat);
                            $('#latitude').val(item.latitude);
                            $('#longitude').val(item.longitude);
                            return {
                                id: item.no_sambungan,
                                text: item.nama + ' - ' + item.no_sambungan,
                            };
                        });
                        return {
                            results: results,
                        }
                    },
                },
            });
        })
    </script>
@endsection
