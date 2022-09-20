@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container">
            <form action="{{ isset($data) ? route('user.update', $data->uuid) : route('user.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Buat User</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"
                                        title="Collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="staff_id">Karyawan</label>
                                    <select name="staff_id" id="staff_id" class="form-control select2">
                                        <option value="">-- Pilih Karyawan --</option>
                                        @forelse ($staff as $item)
                                            <option value="{{ $item->uuid }}" data-name="{{ $item->nama }}"
                                                {{ isset($data) && $data->staff->staff_id == $item->uuid ? 'selected' : '' }}
                                                {{ old('staff_id') == $item->uuid ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama<code>*</code></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ $data->name ?? old('name') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Username<code>*</code></label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ $data->username ?? old('username') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email<code>*</code></label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        value="{{ $data->email ?? old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password<code>*</code></label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        value="{{ $data->password ?? old('password') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role<code>*</code></label>
                                    <select name="role" id="role" class="form-control select2">
                                        <option value="">-- Pilih Role --</option>
                                        @forelse ($roles as $item)
                                            <option value="{{ $item->role }}"
                                                {{ isset($data) && $data->role == $item->role ? 'selected' : '' }}
                                                {{ old('role') == $item->role ? 'selected' : '' }}>
                                                {{ $item->role }}</option>
                                        @empty
                                            <option value="">Tidak ada data</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('user') }}" class="btn btn-secondary mx-1">Kembali</a>
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
        $('#staff_id').change(function(e) {
            e.preventDefault();
            let name = $(this).find(':selected').data('name');
            $('#name').val(name);
        });
    </script>
@endsection
