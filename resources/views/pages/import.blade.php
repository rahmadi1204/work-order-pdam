@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="alert alert-success alert-dismissible" role="alert" id="alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <b class="message"></b>
            </div>
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Import Client</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="#" method="post" enctype="multipart/form-data" id="form-import-excel-client">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" class="form-control" accept=".xlsx, .xls, .csv" name="file">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary import-client">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Import Staff</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="#" method="post" enctype="multipart/form-data" id="form-import-excel-staff">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" class="form-control" accept=".xlsx, .xls, .csv" name="file">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning import-staff">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Import Wilayah</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="#" method="post" enctype="multipart/form-data" id="form-import-excel-wilayah">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" class="form-control" accept=".xlsx, .xls, .csv" name="file">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-success import-wilayah">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Import Kelurahan</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="#" method="post" enctype="multipart/form-data" id="form-import-excel-kelurahan">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <input type="file" class="form-control" accept=".xlsx, .xls, .csv" name="file">
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger import-kelurahan">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
    </section>
@endsection
@section('modal')
@endsection
@section('scripts')
    <script>
        function swalAlert(text, title, icon) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                timer: 2000,
                timerProgressBar: true,
            })
        }
    </script>
    <script>
        $('#alert-success').hide();
        $('.import-client').click(function(e) {
            e.preventDefault();
            let form = $('#form-import-excel-client');
            let formData = new FormData(form[0]);
            swalAlert('Importing...', 'Please wait...', 'info');
            $.ajax({
                type: "post",
                url: "{{ route('import.client') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $('#alert-success').show();
                        $('.message').text(response.message);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    })
                }
            });
            form[0].reset();
        });
        $('.import-wilayah').click(function(e) {
            e.preventDefault();
            let form = $('#form-import-excel-wilayah');
            let formData = new FormData(form[0]);
            swalAlert('Importing...', 'Please wait...', 'info');
            $.ajax({
                type: "post",
                url: "{{ route('import.wilayah') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $('#alert-success').show();
                        $('.message').text(response.message);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    })
                }
            });
            form[0].reset();
        });
        $('.import-kelurahan').click(function(e) {
            e.preventDefault();
            let form = $('#form-import-excel-kelurahan');
            let formData = new FormData(form[0]);
            swalAlert('Importing...', 'Please wait...', 'info');
            $.ajax({
                type: "post",
                url: "{{ route('import.kelurahan') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $('#alert-success').show();
                        $('.message').text(response.message);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    })
                }
            });
            form[0].reset();
        });
        $('.import-staff').click(function(e) {
            e.preventDefault();
            let form = $('#form-import-excel-staff');
            let formData = new FormData(form[0]);
            swalAlert('Importing...', 'Please wait...', 'info');
            $.ajax({
                type: "post",
                url: "{{ route('import.staff') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $('#alert-success').show();
                        $('.message').text(response.message);
                    } else {
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        });
                    }
                },
                error: function(response) {
                    console.log(response);
                    Toast.fire({
                        icon: 'error',
                        title: response.message
                    })
                }
            });
            form[0].reset();
        });
    </script>
@endsection
