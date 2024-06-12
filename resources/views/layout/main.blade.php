<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="/js/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="/js/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/js/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/js/dist/css/adminlte.min.css">
    <!-- ajax -->
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <style>
        .toast-success {
            background-color: rgb(49, 171, 81) !important;
        }

        .toast-error {
            background-color: rgb(211, 65, 65) !important;
        }

        .fixed-top {
            /* position: unset !important; */
        }

        .required {
            color: rgb(239, 81, 81);
        }

        .modal {
            overflow-y: auto !important;
        }

        @media (min-width: 1000px) {
            .main-header {
                margin: 0px 250px !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('layout.header')
    @yield('content')
    @include('layout.footer')

    <div class="Toastify"></div>
    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- common --}}
    @stack('scripts')
    <script>
        var user = null;

        $(document).ready(function() {
            user = JSON.parse(localStorage.getItem('user'));
            if (user) {
                $('.block-login').css('display', 'none');
                $('.block-account').css('display', 'block');
                $('.txt-user-name').text(user.name);
            } else {
                $('.block-login').css('display', 'block');
                $('.block-account').css('display', 'none');
            }
        });

        $(document).on('click', '.btn-logout', function() {
            localStorage.removeItem('user');
            $('.block-login').css('display', 'block');
            $('.block-account').css('display', 'none');
            $('.txt-user-name').text('Tài khoản')
        });

        function showLoginModal() {
            var modal = document.getElementById('loginModal');
            modal.classList.toggle('active');
        }

        $(document).on('click', '.btn-login', function() {
            $.ajax({
                type: "POST",
                data: {
                    name: $('#name').val(),
                    password: $('#password').val(),
                },
                url: "/api/auth/login",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success(response.message, "Thông báo");
                        closeModal('modalLogin');
                        localStorage.setItem('user', JSON.stringify(response.user));
                        $('.block-login').css('display', 'none');
                        $('.block-account').css('display', 'block');
                        $('.txt-user-name').text(response.user.name);
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        });

        $(document).on('click', '.btn-register', function() {
            $.ajax({
                type: "POST",
                data: {
                    name: $('#name_register').val(),
                    password: $('#password_register').val(),
                    re_password: $('#re_password_register').val(),
                },
                url: "/api/auth/register",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success(response.message, "Thông báo");
                        closeModal('modalRegister');
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        });

        $(document).on('click', '.btn-change-password', function() {
            user = JSON.parse(localStorage.getItem('user'));
            $('#name_change').val(user.name || '');

            $.ajax({
                type: "POST",
                data: {
                    name: $('#name_change').val(),
                    password: $('#password_change').val(),
                    new_password: $('#new_password_change').val(),
                },
                url: "/api/auth/changePassword",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success(response.message, "Thông báo");
                        closeModal('modalChangePassword');
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        });

        $(document).on('click', '.btn-open-change-password', function() {
            user = JSON.parse(localStorage.getItem('user'));
            $('#name_change').val(user.name || '');
        });

        function closeModal(id) {
            $("#" + id).css("display", "none");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        }
    </script>
</body>

</html>
