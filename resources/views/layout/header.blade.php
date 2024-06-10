<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
        <div class="navbar-brand">
            <div class="d-flex align-items-center" href="/">
                <img src="logo.png" alt="Designer Farm" style="max-height: 60px; width: auto;">
                <a href="/" class="logo-text ml-2">DESIGNER FARM</a>
            </div>
        </div>
        <div class="navbar-brand">
            <div class="d-flex align-items-center" href="/">
                <a href="{{route('packages.index')}}" class="logo-text ml-2">PACKAGES</a>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown" id="userInfoLi" style="display: none;">
                    <div class="dropdown">
                        <div class="premium-icon">
                            <img alt="" loading="lazy" width="16" height="16" decoding="async"
                                data-nimg="1" class="_24ydrq0 _1286nb11m _1286nb12ql"
                                src="https://static.cdnpk.net/_next/static/media/crown.44cceef2.svg"
                                style="color: transparent;">
                        </div>
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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <button class="btn-open-login btn btn-primary" style="display: none" type="button"
                        id="userDropdown" data-toggle="modal" data-target="#modalLogin" aria-haspopup="true"
                        aria-expanded="false">
                        ĐĂNG NHẬP
                    </button>
                    <a class="block-account nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="txt-user-name mr-2 d-none d-lg-inline text-gray-600 small">Tài khoản</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalCharge"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Charge
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Settings
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                            Activity Log
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item btn-logout" href="#">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>
        </div>

    </div>
</nav>
<div class="modal fade" id="modalCharge" style="display: none;" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Nạp tiền</h4>
                <button type="button" class="closeModalCharge close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <div class="card card-primary card-outline card-outline-tabs">
                            <div class="card-header p-0 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-home-tab" data-toggle="pill"
                                            href="#custom-tabs-four-home" role="tab"
                                            aria-controls="custom-tabs-four-home" aria-selected="false">Chuyển khoản</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                            href="#custom-tabs-four-profile" role="tab"
                                            aria-controls="custom-tabs-four-profile" aria-selected="false">Nhân sự</a>
                                    </li> --}}
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-four-tabContent">
                                    <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-home-tab">
                                        <div class="text-center">
                                            Bạn vui lòng CK số tiền muốn nạp bằng cách quét mã QR của 1 trong 2 ngân
                                            hàng sau:
                                        </div>
                                        <div class="col-sm-12 col-md-12">
                                            <br>
                                            <div class="clear text-center">
                                                <div style="margin: 10px 0px 10px 0px">
                                                    <img src="/assets/images/qrcode-vtin.png">
                                                </div>
                                                <div>
                                                    <strong class="green">VIETINBANK</strong><br>
                                                    108868647721<br>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12">
                                            <br>
                                            <br>
                                            <div class="text-center">
                                                <strong style="line-height: 30px;">Nội dung CK bắt buộc là: <span
                                                        class="orange"
                                                        style="font-size: 30px; line-height: 23px;">sha<span
                                                            id="ucPopupMoney_moneyID">350033</span></span></strong><br>
                                                <em>(Trong đó <strong>sha</strong><strong
                                                        id="ucPopupMoney_moneyID2">350033</strong> để xác định tài
                                                    khoản của bạn, Hệ thống sẽ cộng tiền vào tài khoản này cho bạn)</em>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="col-xs-12">
                                            <div class="bg-pop">
                                                <ul class="introduce-list">
                                                    <li>Phải nhập chính xác nội dung CK mà hệ thống đã hiển thị sẵn cho
                                                        bạn, để được CỘNG TIỀN TỰ ĐỘNG.</li>
                                                    <li>Trường hợp sau vài phút mà bạn không nhận được tiền vui lòng gọi
                                                        tới số hotline <a class="bold" href="tel:+84981282756"
                                                            title="Click gọi ngay!">0981.282.756</a>.</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                        aria-labelledby="custom-tabs-four-profile-tab">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
