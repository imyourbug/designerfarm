<nav class="main-header navbar navbar-expand navbar-white navbar-light" style="height: 80px">
    <ul class="navbar-nav" style="font-weight: bold;height:100%;align-items:center">
        <li class="nav-item" style="height:100%;">
            <a class="nav-link" data-widget="pushmenu" href="/" role="button">
                <img style="max-width: 270px;height:60px; filter: grayscale(100%)" src="{{ $settings['logo'] ?? '' }}" alt="">
            </a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="/" class="nav-link logo-text ml-2">FILE GIÁ RẺ</a>
        </li> --}}
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('packages.index') }}" class="nav-link logo-text ml-2">
                <i class="fa-solid fa-cube"></i> MUA GÓI
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a target="__blank" href="https://help.filegiare.net" class="nav-link logo-text ml-2">
                <i class="fa-solid fa-book"></i> HƯỚNG DẪN CHUNG
            </a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown block-login">
            <a class="nav-link btn btn-primary" data-toggle="dropdown" href="#" aria-expanded="false" style="color: white">
                <i class="fa-solid fa-user"></i>
                <span class="txt-user-name">Tài khoản</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="#" data-toggle="modal" data-target="#modalLogin" class="dropdown-item btn-open-login">
                    <i class="fa-solid fa-key"></i>&emsp13;Đăng nhập
                </a>
                <a href="#" data-toggle="modal" data-target="#modalRegister"
                    class="dropdown-item btn-open-register">
                    <i class="fa-solid fa-registered"></i>&emsp13;Đăng ký
                </a>
            </div>
        </li>
        <li class="nav-item dropdown block-account">
            <a class="nav-link btn btn-success" data-toggle="dropdown" href="#" aria-expanded="false" style="color: white">
                <span>THÔNG TIN GÓI</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <table class="block-package" style="width: max-content;">
                </table>
            </div>
        </li>
        <li class="nav-item dropdown block-account">
            <a class="nav-link btn btn-primary ml-2" data-toggle="dropdown" href="#" aria-expanded="false" style="color: white">
                <span class="txt-user-name"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <a href="{{ route('downloadhistories.index') }}" class="dropdown-item btn-open-download-history">
                    <i class="fa-solid fa-clock-rotate-left"></i>&emsp13;Lịch sử download
                </a>
                <a href="{{ route('requests.index') }}" class="dropdown-item btn-open-download-history">
                    <i class="fa-solid fa-money-bill"></i>&emsp13;Lịch sử giao dịch
                </a>
                <a href="{{ route('members.index') }}" class="dropdown-item btn-open-download-history">
                    <i class="fa-solid fa-cube"></i>&emsp13;Gói đã đăng ký
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" data-toggle="modal" data-target="#modalChangePassword"
                    class="dropdown-item btn-open-change-password">
                    <i class="fa-solid fa-lock"></i></i>&emsp13;Đổi mật khẩu
                </a>
                <a href="#" class="btn-logout dropdown-item">
                    <i class="fa-solid fa-right-from-bracket"></i>&emsp13;Đăng xuất
                </a>
            </div>
        </li>
    </ul>
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
                    <input type="text" name="name" id="name" value="" class="form-control"
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

<div class="modal fade" id="modalRegister" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đăng ký</h4>
                <button type="button" class="closeModalRegister close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" name="name_register" id="name_register" value=""
                        class="form-control" placeholder="Nhập tài khoản">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_register" id="password_register" value=""
                        class="form-control" placeholder="Nhập mật khẩu">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="re_password_register" id="re_password_register" value=""
                        class="form-control" placeholder="Nhập lại mật khẩu">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button style="width: 100%" class="btn btn-primary btn-register">Đăng ký</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalChangePassword" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đổi mật khẩu</h4>
                <button type="button" class="closeModalChangePassword close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" name="name_change" id="name_change" value="" class="form-control"
                        placeholder="Nhập tài khoản">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password_change" id="password_change" value=""
                        class="form-control" placeholder="Nhập mật khẩu">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="new_password_change" id="new_password_change" value=""
                        class="form-control" placeholder="Nhập lại mật khẩu mới">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <button style="width: 100%" class="btn btn-primary btn-change-password">Đổi mật khẩu</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
