<!doctype html>
<html lang="en">

<head>
    <title>PDAM Kota Madiun | {{ $title ?? 'Login' }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{ asset('/assets/login') }}/css/style.css">
    <link rel="shortcut icon" href="{{ asset('/images/logo-pdam.png') }}" type="image/x-icon">
</head>

<body class="img js-fullheight" style="background-image: url({{ asset('/images/pdam-tamansari.jpg') }});">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <h2 class="heading-section">
                        <strong>
                            SISPEKA <br>
                            PDAM Kota Madiun
                        </strong>
                    </h2>
                    <h3 class="mb-4 text-center text-white">(Sistem Surat Perintah Kerja)</h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        @error('username')
                            <div class="alert alert-danger" role="alert">
                                {{ $message }}
                            </div>
                        @enderror
                        <form action="{{ route('login') }}" class="signin-form" method="post" id="form-login">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username"
                                    value="superadmin" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" name="password" type="password" class="form-control"
                                    value="password" placeholder="Password" required>
                                <span toggle="#password-field"
                                    class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn btn-primary px-3" id="btn-login">Sign
                                    In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                    <label class="checkbox-wrap checkbox-primary">Remember Me
                                        <input type="checkbox" name="remember" checked>
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                {{-- <div class="w-50 text-md-right">
                                    <a href="#" style="color: #fff">Forgot Password</a>
                                </div> --}}
                            </div>
                        </form>
                        {{-- <p class="w-100 text-center">&mdash; Or Sign In With &mdash;</p>
                        <div class="social d-flex text-center">
                            <a href="#" class="px-2 py-2 mr-md-1 rounded"><span
                                    class="ion-logo-facebook mr-2"></span> Facebook</a>
                            <a href="#" class="px-2 py-2 ml-md-1 rounded"><span
                                    class="ion-logo-twitter mr-2"></span> Twitter</a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('/assets/login') }}/js/jquery.min.js"></script>
    <script src="{{ asset('/assets/login') }}/js/popper.js"></script>
    <script src="{{ asset('/assets/login') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('/assets/login') }}/js/main.js"></script>
</body>

</html>
