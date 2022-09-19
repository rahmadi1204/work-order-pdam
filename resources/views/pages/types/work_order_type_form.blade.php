@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container">
            <form action="{{ isset($data) ? route('type.work-order.update', $data->uuid) : route('type.work-order.store') }}"
                method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Jenis Work order</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_work_order">Nomor Work Order<code>*</code></label>
                                    <input type="number"name="no_work_order" id="no_work_order" class="form-control"
                                        value="{{ $data->no_work_order ?? old('no_work_order') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kode_work_order">Kode Work Order<code>*</code></label>
                                    <input type="text"name="kode_work_order" id="kode_work_order" class="form-control"
                                        value="{{ $data->kode_work_order ?? old('kode_work_order') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis_work_order">Jenis Work Order<code>*</code></label>
                                    <input type="text"name="jenis_work_order" id="jenis_work_order" class="form-control"
                                        value="{{ $data->jenis_work_order ?? old('jenis_work_order') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="pts">PTS</label>
                                    <input type="number"name="pts" id="pts" class="form-control"
                                        value="{{ $data->pts ?? old('pts') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="kategori_jabatan">Unit Petugas<code>*</code></label>
                                    <select name="kategori_jabatan" id="kategori_jabatan" class="form-control select2">
                                        <option value="">-- Pilih Petugas --</option>
                                        @forelse ($staffs as $item)
                                            <option value="{{ $item->kategori_jabatan }}"
                                                {{ isset($data) && $data->responder == $item->kategori_jabatan ? 'selected' : '' }}
                                                {{ old('kategori_jabatan') == $item->kategori_jabatan ? 'selected' : '' }}>
                                                {{ $item->kategori_jabatan }}</option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Enter ...">{{ $data->keterangan ?? old('keterangan') }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('type.work-order') }}" class="btn btn-secondary mx-1">Kembali</a>
                                    <button type="submit" class="btn btn-primary mx-1">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $('#no_work_order').change(function(e) {
            e.preventDefault();
            let no = $(this).val();
            if (no.length == 1) {
                no = '00' + no;
            } else if (no.length == 2) {
                no = '0' + no;
            }
            $('#kode_work_order').val('WO-' + moment().format('YYMM') + no);
        });
        // $('#staff_id').change(function(e) {
        //     e.preventDefault();
        //     let id = $(this).val();
        //     let nip = $(this).find(':selected').data('nip');
        //     let kategori_jabatan = $(this).find(':selected').data('kategori_jabatan');
        //     let jabatan = $(this).find(':selected').data('jabatan');
        //     $('#nip').val(nip);
        //     $('#kategori_jabatan').val(kategori_jabatan);
        //     $('#jabatan').val(jabatan);
        // });
        // $('#staff_id option:selected').each(function() {
        //     let nip = $(this).data('nip');
        //     let kategori_jabatan = $(this).data('kategori_jabatan');
        //     let jabatan = $(this).data('jabatan');
        //     $('#nip').val(nip);
        //     $('#kategori_jabatan').val(kategori_jabatan);
        //     $('#jabatan').val(jabatan);
        // });
    </script>
@endsection
