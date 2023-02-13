<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>LOGIN PAGE | RESERVASI TIKET</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logo/ancol_with_bg.jpg') }}" rel="icon">
    <link href="{{ asset('assets/img/logo/ancol_with_bg.jpg') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="{{ asset('assets/font/font1.ttf') }}"> --}}
    <style>
        @font-face {
            font-family: 'Grenadine MVB Med';
            src: url('{{ asset('assets/font/font1.ttf') }}');
        }

        #contoh {
            font-family: 'Grenadine MVB Med';
        }

        .logo-ancol {
            height: 3em;
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .pageLoader {
            background: url('/assets/img/loader2.gif') no-repeat center center;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999999;
            background-color: #ffffff8c;

        }
    </style>
    {!! NoCaptcha::renderJs() !!}
</head>

<body>
    <div class="pageLoader" id="pageLoader"></div>
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            {{-- <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <span class="d-none d-lg-block">
                                        <img src="{{ asset('assets/img/logo/ancol_no_bg.png') }}" alt="logo-ancol"
                                            srcset="" class="logo-ancol">
                                    </span>
                                </a>
                            </div><!-- End Logo --> --}}

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">
                                            Reservasi Tiket
                                            <br>
                                            <img src="{{ asset('assets/img/logo/ancol_no_bg.png') }}" alt="logo-ancol"
                                                srcset="" class="logo-ancol">
                                        </h5>
                                        <p class="text-center small" id="contoh">SILAHKAN Silahkan Masukan Email &
                                            Password
                                        </p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate method="POST"
                                        action="{{ route('post-login') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="email">
                                                    <i class="bi bi-envelope"></i>
                                                </span>
                                                <input type="email" name="email" class="form-control" id="email"
                                                    required>
                                                <div class="invalid-feedback">Please enter your email.</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="email" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="email">
                                                    <i class="bi bi-eye"></i>
                                                </span>
                                                <input type="password" name="password" class="form-control"
                                                    id="password" required>
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkPassword">
                                                <label class="form-check-label" for="checkPassword">Show
                                                    Password</label>
                                            </div>
                                        </div>
                                        <div
                                            class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            <label class="col-md-4 control-label">Captcha</label>
                                            <div class="col-md-6">
                                                {!! app('captcha')->display() !!}
                                                @if ($errors->has('g-recaptcha-response'))
                                                    <span class="badge bg-danger">
                                                        <i class="bi bi-exclamation-octagon me-1"></i>
                                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                                    </span>
                                                    {{-- <span class="help-block">

                                                    </span> --}}
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Belum memiliki akun ?
                                                <a href="{{ route('register') }}">Buat Akun</a>
                                            </p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="credits">

                            </div>
                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.3.js') }}"></script>
    <script src="{{ asset('assets/js/moment.js') }}"></script>
    @include('sweetalert::alert')
    <script>
        $(document).ready(function() {
            $('#email', '#password').val('');
            $('.credits').html('Copyright &copy; ' + moment().year());
            $('#checkPassword').click(function() {
                if ($(this).is(':checked')) {
                    $('#password').attr('type', 'text');
                } else {
                    $('#password').attr('type', 'password');
                }
            });
        })
    </script>
    <script>
        $(window).on('beforeunload', function() {

            $('#pageLoader').show();

        });

        $(function() {

            $('#pageLoader').hide();
        })
    </script>
</body>

</html>
