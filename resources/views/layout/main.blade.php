<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="description" content="Trang hỗ trợ getlink freepik, tải ảnh freepik, tải video freepik, tải hình freepik premium, download freepik file giá tốt nhất thế giới">
    <link rel="icon" href="/storage/upload/2024-06-30/07-38-36downloading.png">
    <title>TẢI FILE FREEPIK GIÁ RẺ - {{ $title }}</title>
    <meta property="og:description" content="Trang tải hình ảnh, vector từ freepik, elements envato giá rẻ nhất thế giới, hoàn toàn tự động, phục vụ 24/24">
    <meta property="og:title" content="Trang tải hình ảnh, vector từ freepik, elements envato giá rẻ nhất thế giới, hoàn toàn tự động, phục vụ 24/24">
    <meta name="keywords" content="getlink shuterstock, getlink pikbest, getlink pngtree, getlink freepik, leech link pikbest, leechlink freepik, get item from pikbest, get item from pngtree, get item from freepik, download item pikbest, download item freepik, get item premium pikbest, get item premium freepik, get item premium lovepik">
    <meta name="description" content="Trang getlink shutterstock miễn phí, getlink elements envato, getlink freepik hoàn toàn tự động và tiết kiệm chi phí!">
    <meta itemprop="name" content="Trang tải hình ảnh, vector từ freepik, elements envato giá rẻ nhất thế giới, hoàn toàn tự động, phục vụ 24/24">
    <meta itemprop="description" content="Trang tải hình ảnh, vector từ freepik, elements envato giá rẻ nhất thế giới, hoàn toàn tự động, phục vụ 24/24">
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
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <meta name="csrf-token" id="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    {{-- bootstrap --}}
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    {{-- Jquery --}}
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
                padding: 0px 250px !important;
                margin: 0px !important;
            }
        }

        nav.main-header {
            width: 100%;
            position: fixed;
            top: 0px;
        }

        .dropdown-menu {
            top: 7px !important;
        }

        @media (max-width: 1000px) {
            .di-md-none {
                display: none !important;
            }
            .description-package {
                margin-left: 0px !important;
            }
            .image-package {
                text-align: left !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @include('layout.header')
    <div class="content">
        @yield('content')
    </div>
    @include('layout.footer')
    <div class="modal fade" id="modalAlertChargedSuccessfully" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thông báo</h4>
                    <button type="button" class="closeModalAlertChargedSuccessfully close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Bạn đã mua gói thành công!</h3>
                    <p>Nhấn vào đây để xem các gói đã đăng ký <a href="{{ route('members.index') }}">click</a></p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
    <div class="gototop js-top active" style="position: fixed;bottom:40px;right:40px">
        <a target="_blank" href="{{ $settings['link-messenger'] ?? '' }}" class="js-gotop">
            <img src="/image/mess.jpg" style="width: 50px;height:50px" alt="">
        </a>
    </div>
    <div class="gototop js-top active" style="position: fixed;bottom:100px;right:40px">
        <a target="_blank" href="{{ $settings['link-zalo'] ?? '' }}" class="js-gotop">
            <img src="/image/zalo.jpg" style="width: 50px;height:50px" alt="">
        </a>
    </div>
    {{-- <input type="hidden" id="btn-clode-all-modal" data-dismiss="modal"/> --}}
    <input type="hidden" id="btn-open-modal-alert-charged-successfully" data-toggle="modal"
        data-target="#modalAlertChargedSuccessfully" />
    <div class="Toastify"></div>
    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- common --}}
    <script>
        var user = null;

        $(document).ready(function() {
            user = JSON.parse(localStorage.getItem('user'));
            members = JSON.parse(localStorage.getItem('members'));
            if (user) {
                $('.block-login').css('display', 'none');
                $('.block-account').css('display', 'block');
                $('.txt-user-name').text(user.name);
            } else {
                $('.block-login').css('display', 'block');
                $('.block-account').css('display', 'none');
            }
            if (members) {
                $('.block-package').html('');
                let html = '';
                members.forEach(e => {
                    html += `
                            <tr>
                                <td style="padding: 10px 15px">
                                    ${e.package_detail.package.name}
                                </td>
                                <td> ${e.number_file - e.downloaded_number_file}/${e.number_file}</td>
                            </tr>`;
                });
                $('.block-package').html(html);
            }
        });

        $(document).on('click', '.btn-logout', function() {
            localStorage.removeItem('user');
            localStorage.removeItem('members');
            $('.block-login').css('display', 'block');
            $('.block-account').css('display', 'none');
            $('.block-package').html('');
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
                        // toastr.success(response.message, "Thông báo");
                        closeModal('modalLogin');
                        localStorage.setItem('user', JSON.stringify(response.user));
                        localStorage.setItem('members', JSON.stringify(response.members));
                        $('.block-login').css('display', 'none');
                        $('.block-account').css('display', 'block');
                        $('.txt-user-name').text(response.user.name);
                        //
                        $('.block-package').html('');
                        let html = '';
                        response.members.forEach(e => {
                            html += `
                            <tr>
                                <td style="padding: 10px 15px">
                                    ${e.package_detail.package.name}
                                </td>
                                <td> ${e.number_file - e.downloaded_number_file}/${e.number_file}</td>
                            </tr>`;
                        });
                        $('.block-package').html(html);
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
    {{-- PUSHER --}}
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    {{-- <script src="//js.pusher.com/3.1/pusher.min.js"></script> --}}
    <script>
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;

        var pusher = new Pusher('{{ env('PUSHER_APP_KEY') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}'
        });

        var channel = pusher.subscribe('AlertChargedSuccessfullyChannel');
        channel.bind('AlertChargedSuccessfullyEvent', function(data) {
            let user = JSON.parse(localStorage.getItem('user'));
            if (user && user.id == data.userId) {
                // $('#btn-clode-all-modal').click();
                $('#btn-open-modal-alert-charged-successfully').click();
                // sync available numberfile
                $.ajax({
                    type: 'GET',
                    url: `/api/members/getMembersByUserId?user_id=${user.id}`,
                    success: function(response) {
                        if (response.members) {
                            $('.block-package').html('');
                            let html = '';
                            response.members.forEach(e => {
                                html += `<tr>
                                                <td style="padding: 10px 15px">
                                                    ${e.package_detail.package.name}
                                                </td>
                                                <td> ${e.number_file - e.downloaded_number_file}/${e.number_file}</td>
                                            </tr>`;
                            });
                            $('.block-package').html(html);
                            //
                            localStorage.setItem('members', JSON.stringify(response.members));
                        }
                    },
                });
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
