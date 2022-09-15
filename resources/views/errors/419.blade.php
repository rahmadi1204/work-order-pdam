@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-warning"> 419</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page expired.</h3>

                <p>
                    Your session has expired.
                    Meanwhile, you may <a href="{{ route('login') }}">login again</a> or try using the search form.
                </p>

                <form class="search-form" id="form-search">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.input-group -->
                </form>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#form-search').submit(function(e) {
                e.preventDefault();
                var search = $('input[name="search"]').val();
                window.location.href = `{{ url('/') }}` + '/' + search;
            });
        });
    </script>
@endsection
