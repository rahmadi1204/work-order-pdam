@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container">
            <form
                action="{{ isset($response) ? route('work-order.response.update', $data->id) : route('work-order.request.update', $data->id) }}"
                method="post" enctype="multipart/form-data">
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
                                    <label for="no_work_order">Tanggal Permintaan<code>*</code></label>
                                    <div class="input-group date">
                                        <input type="text" name="tgl_work_order" class="form-control"
                                            value="{{ isset($data) ? $data->tgl_work_order : old('tgl_work_order') }}"readonly>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_work_order">Jenis Work Order<code>*</code></label>
                                    <input type="text" name="jenis_work_order" class="form-control"
                                        value="{{ $data->type->jenis_work_order ?? old('jenis_work_order') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_jabatan">Unit Petugas<code>*</code></label>
                                    <input type="text" name="kategori_jabatan" id="kategori_jabatan" class="form-control"
                                        value="{{ $data->staff->kategori_jabatan ?? old('kategori_jabatan') }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="staff_id">Petugas<code>*</code></label>
                                    <input type="text" name="staff_id" class="form-control"
                                        value="{{ $data->staff->nama ?? old('staff_id') }}" readonly>
                                </div>
                                @if ($client != null)
                                    <div class="form-group">
                                        <label for="client_id">Pelanggan<code>*</code></label>
                                        <input type="text" name="client_id" class="form-control"
                                            value="{{ $client->nama . ' - ' . $client->no_sambungan ?? old('client_id') }}"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="alamat">Alamat<code>*</code></label>
                                        <input type="text" name="alamat" class="form-control"
                                            value="{{ $client->area->nama_area ?? '' }} {{ $client->alamat ?? old('alamat') }}"
                                            readonly>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="keterangan_work_order">Keterangan</label>
                                    <textarea name="keterangan_work_order" id="keterangan_work_order" class="form-control" rows="3"
                                        placeholder="Enter ..." readonly>{{ $data->keterangan_work_order ?? old('keterangan_work_order') }}</textarea>
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
                                    <label for="tgl_work_order_response">Tanggal Pengerjaan<code>*</code></label>
                                    <div class="input-group date" id="datepicker" data-target-input="nearest">
                                        <input type="text" name="tgl_work_order_response"
                                            @isset($response) disabled @endisset
                                            class="form-control datetimepicker-input"
                                            value="{{ isset($data) ? $data->tgl_work_order_response : old('tgl_work_order_response') }}"
                                            data-target="#datepicker" required>
                                        <div class="input-group-append" data-target="#datepicker"
                                            data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @isset($response)
                                    <div class="form-group">
                                        <label for="tgl_work_order_done">Tanggal Selesai<code>*</code></label>
                                        <div class="input-group date" id="datepicker2" data-target-input="nearest">
                                            <input type="text" name="tgl_work_order_done"
                                                class="form-control datetimepicker-input"
                                                value="{{ isset($data) ? $data->tgl_work_order_done : old('tgl_work_order_done') }}"
                                                data-target="#datepicker2" required>
                                            <div class="input-group-append" data-target="#datepicker2"
                                                data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endisset
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
                                    <label for="keterangan_petugas">Keterangan Petugas</label>
                                    <textarea name="keterangan_petugas" id="keterangan_petugas" class="form-control" rows="3"
                                        placeholder="Enter ..."
                                        @isset($response) readonly
                                        @endisset>{{ $data->keterangan_petugas ?? old('keterangan_petugas') }}</textarea>
                                </div>
                                @isset($response)
                                    <div class="form-group">
                                        <label for="keterangan_selesai">Keterangan Selesai</label>
                                        <textarea name="keterangan_selesai" id="keterangan_selesai" class="form-control" rows="3"
                                            placeholder="Enter ..." required>{{ $data->keterangan_selesai ?? old('keterangan_selesai') }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="imageFile">File Foto</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="image" class="custom-file-input"
                                                    id="imageFile">
                                                <label class="custom-file-label" for="imageFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group image-view">
                                        <label for="exampleInputFile">Preview</label>
                                        <div class="row">
                                            @if (isset($data->image))
                                                {{-- @foreach ($data->image as $item) --}}
                                                <div class="col-sm-2">
                                                    <a href="{{ asset($path . $data->image) }}" data-toggle="lightbox"
                                                        data-title="{{ $data->uuid }}" data-gallery="gallery">
                                                        <img src="{{ asset($path . $data->image) }}" class="img-fluid mb-2"
                                                            alt="image" id="img" />
                                                    </a>
                                                </div>
                                                {{-- @endforeach --}}
                                            @else
                                                <div class="col-sm-2">
                                                    <img src="{{ asset('images/no-image.png') }}" class="img-fluid mb-2"
                                                        alt="image" id="img" />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endisset
                                {{-- <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="proses"
                                            {{ isset($data) ? ($data->status == 'proses' ? 'selected' : '') : '' }}>
                                            Proses</option>
                                        <option value="selesai"
                                            {{ isset($data) ? ($data->status == 'selesai' ? 'selected' : '') : '' }}>
                                            Selesai</option>
                                    </select>
                                </div>
                                <div class="form-group tgl-selesai">
                                    <label for="no_work_order">Tanggal Selesai<code>*</code></label>
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
                                </div> --}}
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
            $('#deskripsi').val(keterangan);
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
