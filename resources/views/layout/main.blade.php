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
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <style>
        .toast-success {
            background-color: rgb(49, 171, 81) !important;
        }

        .toast-error {
            background-color: rgb(211, 65, 65) !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('layout.header')
    @yield('content')
    @include('layout.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
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
                $('.btn-open-login').css('display', 'none');
                $('.block-account').css('display', 'block');
                $('.txt-user-name').text(user.email);
            } else {
                $('.btn-open-login').css('display', 'block');
                $('.block-account').css('display', 'none');
            }
        });

        $(document).on('click', '.btn-logout', function() {
            localStorage.removeItem('user');
            $('.btn-open-login').css('display', 'block');
            $('.block-account').css('display', 'none');
        });

        function showLoginModal() {
            var modal = document.getElementById('loginModal');
            modal.classList.toggle('active');
        }

        $(document).on('click', '.btn-login', function() {
            $.ajax({
                type: "POST",
                data: {
                    email: $('#email').val(),
                    password: $('#password').val(),
                },
                url: "/api/auth/login",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success(response.message, "Thông báo");
                        closeModal('modalLogin');
                        localStorage.setItem('user', JSON.stringify(response.user));
                        $('.btn-open-login').css('display', 'none');
                        $('.block-account').css('display', 'block');
                        $('.txt-user-name').text(useresponse.user.email);
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        });

        function closeModal(id) {
            $("#" + id).css("display", "none");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        }
    </script>
</body>

</html>
