<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/template/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
    {{--  --}}
    {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}
    <!-- ajax -->
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#">Quản lý</a>
            </div>
            <div class="card">
                <div class="card-body login-card-body">
                    <form action="{{ route('admin.checkLogin') }}" method="POST">
                        <div class="input-group mb-3">
                            <input name="name" type="name" value="{{ old('name') }}" class="form-control"
                                placeholder="Nhập tài khoản">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" value="{{ old('password') }}" class="form-control"
                                placeholder="Nhập mật khẩu">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
                            </div>
                        </div>
                        @csrf
                    </form>
                    <p class="mb-1">
                        <a href="{{ route('admin.forgot') }}">Quên mật khẩu</a>
                    </p>
                    <!-- <p class="mb-0">
                        <a href="{{ route('admin.register') }}" class="text-center">Đăng ký</a>
                    </p> -->
                </div>
            </div>
        </div>
    </div>
    <script src="http://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    {{-- <script src="/template/admin/plugins/jquery/jquery.min.js"></script> --}}
    <!-- Bootstrap 4 -->
    <script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/template/admin/dist/js/adminlte.min.js"></script>
    <!-- main.js-->
    {{-- <script src="/template/admin/js/main.js"></script> --}}
    <div class="Toastify"></div>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>

</html>
