@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
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
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                accept=".xlsx, .xls, .csv" name="file">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
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

                {{-- <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Import Staff Kategory</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="#" method="post" enctype="multipart/form-data"
                            id="form-import-excel-staff-category">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputFile">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                accept=".xlsx, .xls, .csv" name="file">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary import-staff-category">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div> --}}
                <div class="col-md-6">

                    <!-- general form elements -->
                    <div class="card card-primary">
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
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="exampleInputFile"
                                                accept=".xlsx, .xls, .csv" name="file">
                                            <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                        </div>
                                        <div class="input-group-append">
                                            <span class="input-group-text">Upload</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary import-staff">Submit</button>
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
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
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
        });
        $('.import-staff-category').click(function(e) {
            e.preventDefault();
            let form = $('#form-import-excel-staff-category');
            let formData = new FormData(form[0]);
            swalAlert('Importing...', 'Please wait...', 'info');
            $.ajax({
                type: "post",
                url: "{{ route('import.staff.category') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
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
                        Toast.fire({
                            icon: 'success',
                            title: response.message
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })
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
        });
    </script>
@endsection
