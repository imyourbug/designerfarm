<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav" style="font-weight: bold">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link logo-text ml-2">DESIGNER FARM</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('packages.index') }}" class="nav-link logo-text ml-2">Gói tải</a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <button class="btn-open-login btn btn-primary" style="display: none" type="button" id="userDropdown"
                data-toggle="modal" data-target="#modalLogin" aria-haspopup="true" aria-expanded="false">
                ĐĂNG NHẬP
            </button>
        </li>
        <li class="nav-item dropdown block-account">
            <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                <span class="txt-user-name"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="#" class="dropdown-item btn-open-download-history">
                    <i class="fa-solid fa-clock-rotate-left"></i>&emsp13;Lịch sử download
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="btn-logout dropdown-item">
                    <i class="fa-solid fa-right-from-bracket"></i>&emsp13;Đăng xuất
                </a>
            </div>
        </li>
    </ul>
</nav>
<div class="modal fade" id="modalDownloadHistory" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Lịch sử download</h4>
                <button type="button" class="closeModalCharge close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalLogin" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đăng nhập</h4>
                <button type="button" class="closeModalLogin close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="email" name="email" id="email" value="" class="form-control"
                        placeholder="Nhập tài khoản">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" value="" class="form-control"
                        placeholder="Nhập mật khẩu">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button style="width: 100%" class="btn btn-primary btn-login">Đăng nhập</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click', '.btn-open-download-history', function() {
        user = JSON.parse(localStorage.getItem('user'));
        if (user) {
            $.ajax({
                type: "GET",
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
                        $('.txt-user-name').text(response.user.email);
                    } else {
                        toastr.error(response.message, "Thông báo");
                    }
                },
            });
        }
    });

    var dataTable = null;

    $(document).ready(function() {
        dataTable = $("#table").DataTable({
            layout: {
                topStart: {
                    buttons: [{
                            extend: "excel",
                            text: "Xuất Excel",
                            exportOptions: {
                                columns: ":not(:last-child)",
                            },
                        },
                        "colvis",
                    ],
                },
                top2Start: 'pageLength',
            },
            // ajax: {
            //     url: `/api/requests/getAll`,
            //     dataSrc: "requests",
            // },
            columns: [
                {
                    data: function(d) {
                        return d.user.email;
                    },
                },
                {
                    data: function(d) {
                        return `<b>${d.content}</b>`;
                    },
                },
                {
                    data: function(d) {
                        return d.package.name;
                    },
                },
                {
                    data: function(d) {
                        return `${formatCash(d.total)}`;
                    },
                },
                {
                    data: function(d) {
                        return d.expire;
                    },
                },
                {
                    data: function(d) {
                        return d.package.type == 0 ? 'Tải lẻ' : 'Tải theo tháng hoặc năm';
                    },
                },
                {
                    data: function(d) {
                        return d.package.type == 0 ? 'Không' : d.website_id;
                    },
                },
                {
                    data: function(d) {
                        return getStatus(d.id, d.website_id || '', d.status);
                    },
                },
            ],
        });
    });
</script>
