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
    {{--  --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    {{--  --}}
    {{-- <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> --}}
    <style>
        span.required {
            color: red;
        }

        span.select2-dropdown {
            top: -25px;
        }

        #table_filter {
            text-align: right;
        }

        .hidden {
            display: none;
        }

        .option-open {
            background-color: rgba(255, 255, 255, .1);
        }

        .open-block {
            display: block;
        }

        .open-none {
            display: none;
        }

        .table.dataTable.nowrap th,
        .table.dataTable.nowrap td {
            white-space: normal !important;
        }

        .dataTables_paginate {
            float: right;
        }

        .pagination li {
            margin-left: 10px;
        }

        .select2-container,
        .form-inline,
        .form-inline label {
            display: inline !important;
        }

        .select2-search__field {
            border: none !important;
        }

        .select2-selection__choice__display {
            color: black;
        }

        .icon {
            padding: 3px 4px;
            border-radius: 10px;
        }

        .table {
            width: 100% !important;
        }

        @media (max-width: 600px) {
            .hide-max-600 {
                display: none !important;
                color: white !important;
            }
        }

        .header-color {
            background-color: #28a745;
            color: white;
        }

        .tool-tip {
            position: relative;
            display: inline-block;
            /* border-bottom: 1px dotted black; */
        }

        .tool-tip:hover {
            cursor: pointer;
        }

        .card-body {
            overflow-x: clip !important;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/images/gg.png" alt="Áo đá bóng" height="60"
                width="120">
        </div> --}}
        @include('admin.menu')
        @include('admin.sidebar')

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $title }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @yield('content')
                </div>
            </section>
        </div>
    </div>
    <button style="display:none" class="btn-history" data-target="#modalHistory" data-toggle="modal"></button>
    <input type="file" style="opacity: 0" id="file-restore-db" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/js/dist/js/adminlte.min.js"></script>
    <!-- main.js-->
    {{-- <script src="/js/main.js"></script> --}}
    <div class="Toastify"></div>
    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- common --}}
    <script src="/js/common/index.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            // $(document).tooltip();
            $(' .card-body').css('overflow-x', '');
        });

        function closeModalChangePassword() {
            $("#modalChangePassword").css("display", "none");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        }
        $(document).on('click', '.btn-change-password', function() {
            $.ajax({
                type: "POST",
                data: {
                    name: $('#tel_or_email').val(),
                    new_password: $('#password').val(),
                    password: $('#old_password').val(),
                },
                url: "/api/auth/changePassword",
                success: function(response) {
                    if (response.status == 0) {
                        toastr.success(response.message, "Thông báo");
                        closeModalChangePassword();
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        })
    </script>
    <script>
        function closeModal(id) {
            $("#" + id).css("display", "none");
            $("body").removeClass("modal-open");
            $(".modal-backdrop").remove();
        }
    </script>
    @stack('scripts')
</body>

</html>
