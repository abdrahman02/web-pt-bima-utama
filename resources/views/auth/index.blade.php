<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/logo-pt.jpg') }}">

    <link rel="icon" type="image/png" href="{{ asset('img/logo-pt.jpg') }}">
    <title>
        PT. DAHLIA BINA UTAMA
    </title>
    <!-- Nucleo Icons -->
    <link href="{{ asset('auth/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('auth/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="{{ asset('auth/js/kitfontawesome.js') }}"></script>
    <script src="https://kit.fontawesome.com/23ce94eee2.js" crossorigin="anonymous"></script>
    <link href="{{ asset('auth/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('auth/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body>
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="col-4 shadow-lg mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-12 d-flex flex-column mx-lg-0 mx-auto text-center">
                                    <h4 class="font-weight-bolder">
                                        LOGIN
                                    </h4>
                                    <div class="pb-0 text-start mx-auto">
                                        <img src="img/logo-pt.jpg" alt="logo" style="height: 50px;">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                {{-- Alert --}}
                                @if (session()->has('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span class="alert-text">{{ session('error') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif


                                <form action="{{ route('authenticate') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-lg" name="username"
                                            placeholder="Username" required autofocus />
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control form-control-lg" name="password"
                                            placeholder="Password" aria-label="Password" required />
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('auth/js/popper.min.js') }}"></script>
    <script src="{{ asset('auth/js/bootstrap.min.js') }}"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('auth/js/argon-dashboard.min.js') }}"></script>
</body>

</html>