@extends('layouts.app')
@section('content')
    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-body row">
                <div class="col-5 text-center d-flex align-items-center justify-content-center">
                    <div class="">
                        <h2>Whatsapp <br>
                            <strong id="status-wa"><i class="fas fa-spinner fa-spin "></i>
                                Menghubungkan...</strong>
                        </h2>
                        <p id="status-message"></p>
                        <a href="#" onclick="qrcode()">
                            <img src="{{ asset('images/click.jpg') }}" alt="qr" class="img-fluid p-3" id="qrcode">
                        </a>
                        <p id="footer-qrcode"></p>
                    </div>
                </div>
                <div class="col-7">
                    <form action="{{ route('whatsapp.update', $data->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="phone">Nomor Whatsapp</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="text" name="phone" class="form-control hp" placeholder="Nomor Whatsapp"
                                    value="{{ $phone ?? old('phone') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="server">Server</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-server"></i></span>
                                </div>
                                <input type="text" name="url_server" class="form-control" placeholder="Server Whatsapp"
                                    value="{{ $data->url_server ?? old('url_server') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Update">
                        </div>
                    </form>
                    <form action="{{ route('whatsapp.send') }}" method="post" id="form-send-message" class="d-none"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="from" value="{{ $data->phone }}">
                        <div class="form-group">
                            <label for="phone">Nomor Tujuan</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="text" name="receiver" class="form-control hp" placeholder="Nomor Whatsapp"
                                    value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea name="message" id="message" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <br>
                            <input type="file" name="file" id="file" class="form-control"
                                accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf">
                            <code>jenis file : .xlsx,.xls,image/*,.doc, .docx,.ppt,
                                .pptx,.txt,.pdf</code>
                            <br>
                            <code>ukuran maksimal : 5mb</code>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Kirim">
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
@section('modal')
@endsection
@section('scripts')
    <script>
        function checkStatus() {
            $.ajax({
                type: "get",
                url: "{{ url($data->url_server) }}" + "/api/status",
                data: {
                    from: "{{ $data->phone }}"
                },
                success: function(response) {
                    if (response) {
                        if (response.data.status == 'authenticated') {
                            $('#status-wa').html('Terhubung');
                            $('#status-wa').removeClass('text-danger');
                            $('#status-wa').addClass('text-success');
                            $('#qrcode').attr('src', "{{ asset('images/whatsapp.png') }}");
                            $('#status-message').html('');
                            $('#footer-qrcode').html('');
                            $('#form-send-message').removeClass('d-none');
                            clearInterval(intervalqr);
                        } else {
                            $('#status-wa').html('Terputus');
                            $('#status-wa').removeClass('text-success');
                            $('#status-wa').addClass('text-danger');
                            $('#form-send-message').addClass('d-none');
                        }
                    } else {
                        $('#status-wa').html('Terputus');
                        $('#status-wa').removeClass('text-success');
                        $('#status-wa').addClass('text-danger');
                        $('#form-send-message').addClass('d-none');
                    }
                },
                error: function(response) {
                    console.log(response);
                    $('#status-wa').html('Terputus');
                    $('#status-wa').removeClass('text-success');
                    $('#status-wa').addClass('text-danger');
                    $('#status-message').html('Klik gambar untuk menghubungkan');
                    $('#form-send-message').addClass('d-none');
                }
            });
        }

        function qrcode() {
            $("#footer-qrcode").text(
                "Tunggu sebentar...");
            let time = 28000;
            $.ajax({
                type: "post",
                url: "{{ url($data->url_server) }}" + "/api/delete",
                data: {
                    from: "{{ $data->phone }}"
                },
                success: function(response) {
                    addSession();
                },
                error: function(response) {
                    console.log(response);
                }
            });

        }

        function check() {
            $.ajax({
                type: "post",
                url: "{{ url($data->url_server) }}" + "/api/add",
                data: {
                    from: "{{ $data->phone }}"
                },
                success: function(response) {
                    let success = response.success;
                    if (success) {
                        $('#status-wa').html('Terputus');
                        $('#status-wa').removeClass('text-success');
                        $('#status-wa').addClass('text-danger');
                        $('#status-message').html('Klik gambar untuk menghubungkan');
                        $('#form-send-message').addClass('d-none');
                    } else {
                        checkStatus();
                    }
                }
            });
        }
        check();

        function addSession() {
            $.ajax({
                type: "post",
                url: "{{ url($data->url_server) }}" + "/api/add",
                data: {
                    from: "{{ $data->phone }}"
                },
                success: function(response) {
                    let success = response.success;
                    if (success) {
                        let qrcode = response.data.qr;
                        $('#status-message').html('Scan QR Code');
                        $('#status-wa').html('Terputus');
                        $('#status-wa').removeClass('text-success');
                        $('#status-wa').addClass('text-danger');
                        $('#qrcode').attr('src', qrcode);
                        let time = 28000;
                        const intervalqr = setInterval(function() {
                            time = time -
                                2000; //reduce each second
                            $("#footer-qrcode").text(
                                "Akan ditutup dalam " + time /
                                1000 + " detik");
                            if (time < 0) {
                                $('#footer-qrcode').html('');
                                $('#qrcode').attr('src', "{{ asset('images/click.jpg') }}");
                                window.location.reload();
                            } else {
                                checkStatus();
                            }
                        }, 2000);
                    } else {
                        checkStatus();
                    }
                }
            });
        }
    </script>
@endsection
