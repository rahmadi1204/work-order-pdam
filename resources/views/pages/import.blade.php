@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-6">
                    <div class="alert alert-success">
                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                        Success alert preview. This alert is dismissable.
                    </div>
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Alert!</h5>
                        Info alert preview. This alert is dismissable.
                    </div>
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                        Warning alert preview. This alert is dismissable.
                    </div>
                    <div class="alert alert-danger">
                        <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                        Danger alert preview. This alert is dismissable.
                    </div>

                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Import</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('import.store') }}" method="post" enctype="multipart/form-data"
                            id="form-import-excel">
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
                                <button type="submit" class="btn btn-primary import">Submit</button>
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
        $('.import').click(function(e) {
            e.preventDefault();
            let form = $('#form-import-excel');
            let formData = new FormData(form[0]);
            swalAlert('Importing...', 'Please wait...', 'info');
            $.ajax({
                type: "post",
                url: "{{ route('import.store') }}",
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
                        })
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
        $('.alert').hide();

        function alertSuccess() {
            $('.alert-success').show();
        }

        function alertError() {
            $('.alert-danger').show();
        }
    </script>
@endsection
