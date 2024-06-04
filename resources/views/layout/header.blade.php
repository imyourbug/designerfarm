<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
        <!-- Logo và tiêu đề -->
        <div class="navbar-brand">
            <div class="d-flex align-items-center" href="/">
                <img src="logo.png" alt="Designer Farm" style="max-height: 60px; width: auto;">
                <div class="logo-text ml-2">DESIGNER FARM</div>
            </div>
        </div>
        <!-- Nút toggle cho responsive navbar -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Danh sách các liên kết -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Dropdown cho đăng nhập -->
                <li class="nav-item dropdown" id="userDropdownLi">
                    <button class="btn-open-login btn btn-primary" type="button" id="userDropdown"
                        data-toggle="modal" data-target="#modalLogin" aria-haspopup="true" aria-expanded="false">
                        ĐĂNG NHẬP
                    </button>
                    <button class="btn-logout btn btn-primary" style="display: none">
                        ĐĂNG XUẤT
                    </button>
                </li>
                <!-- Dropdown hiển thị thông tin người dùng -->
                <li class="nav-item dropdown" id="userInfoLi" style="display: none;">
                    <!-- Nút dropup hiển thị User ID -->
                    <!-- Dropdown -->
                    <div class="dropdown">
                        <!-- Thêm icon premium vào góc trên bên phải -->
                        <div class="premium-icon">
                            <img alt="" loading="lazy" width="16" height="16" decoding="async"
                                data-nimg="1" class="_24ydrq0 _1286nb11m _1286nb12ql"
                                src="https://static.cdnpk.net/_next/static/media/crown.44cceef2.svg"
                                style="color: transparent;">
                        </div>
                        <!-- Thay đổi nội dung của nút dropdown thành userID -->
                        <button onclick="toggleDropdown()" class="dropbtn" id="userInfoBtn">User ID</button>
                        <div id="userInfoDropdown" class="dropdown-content">
                            <a id="packageTimeLink"></a>
                            <a id="filesDownloadedLink"></a>
                            <a class="btn btn-danger btn-block btn-3d _1286nb1239 _1286nb12d9 _1286nb12sf _1286nb111 _1286nb12nr _1286nb1v _1286nb16ea _1286nb15np _1286nb17q"
                                data-cy="logout-button" onclick="logout()">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="-49 141 512 512" width="16"
                                    height="16" aria-hidden="true"
                                    class="_24ydrq0 _1286nb11sr _1286nb11h9 _1286nb11m _1286nb12q9">
                                    <path
                                        d="M207 372c-13.807 0-25-11.193-25-25V166c0-13.807 11.193-25 25-25s25 11.193 25 25v181c0 13.807-11.193 25-25 25">
                                    </path>
                                    <path
                                        d="M370.342 258.658c-27.847-27.847-61.558-47.693-98.342-58.419v52.84C339.785 279.251 388 345.096 388 422c0 99.804-81.196 181-181 181S26 521.804 26 422c0-76.904 48.215-142.749 116-168.921v-52.84c-36.784 10.726-70.494 30.572-98.342 58.419C.028 302.288-24 360.298-24 422S.028 541.712 43.658 585.342 145.298 653 207 653s119.712-24.028 163.342-67.658S438 483.702 438 422s-24.028-119.712-67.658-163.342">
                                    </path>
                                </svg>
                                Log out
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
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
                    <input type="email" name="email" id="email" value=""
                        class="form-control" placeholder="Nhập tài khoản">
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