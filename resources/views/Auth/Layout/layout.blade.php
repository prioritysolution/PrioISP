<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="prioisp - ISP Billing Management" />
    <meta name="keywords" content="prioisp, isp, billing, internet" />
    <meta name="author" content="Priority Solutions" />
    <meta name="robots" content="noindex, nofollow" />
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>prioisp</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logo.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}" />

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
</head>

<body class="account-page">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>
    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">

                    @yield('section')

                </div>
                <div class="login-img">
                    <img src="{{ asset('assets/img/login.jpg') }}" alt="img" />
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('assets/js/feather.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/alert.js') }}"></script>
    <script>
        var baseurl = "{{ url('/') }}";
    </script>

    @stack('script')

</body>

</html>
