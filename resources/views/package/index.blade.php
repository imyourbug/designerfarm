@extends('layout.main')
@push('styles')
    <title>TẢI FILE FREEPIK GIÁ RẺ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/css/package/index.css" rel="stylesheet">
    <style>
        .option {
            border: 1px solid purple;
            border-radius: 5px;
            margin: 5px auto;
            padding: 5px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .option label {
            margin-bottom: 0px;
        }

        .option div {
            border: none;
        }

        .block-money {
            border-radius: 5px;
            background-color: #F2F3F6;
            margin: 0 auto;
            padding: 10px 0px;
            font-weight: bold;
        }

        .type-number-file {
            font-weight: bold;
        }
    </style>
@endpush
@push('scripts')
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            var intervalGetUrl = null;
            // default
            $('#Freepik').click();
            //
        });

        $(document).on('click', '.btn-open-detail', function() {
            let user = JSON.parse(localStorage.getItem('user'));
            $('.btn-close-modal').click();
            if (!user) {
                toastr.error('Bạn cần đăng nhập để đăng ký dịch vụ');
                $('.btn-open-login').click();
            } else {
                let idPackage = $(this).data('id');
                $.ajax({
                    method: "GET",
                    url: `/api/packages/getPackageById`,
                    data: {
                        id: idPackage
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            let package = response.package;
                            $('#package_type').val(package.type);
                            $('#package_id').val(package.id);
                            let newPrice = package.price_sale ? package.price_sale : package.price;
                            if (package.type == 0) {
                                $('.package_name').text(package.name);
                                $('.package_number_file').text(`${package.number_file} file/năm`);
                                $('.total').text(
                                    `${formatCash(newPrice)}đ`);
                                $('.total').data('total',
                                    `${newPrice}`);
                            }
                            if (package.type == 1) {
                                $('#type-time-first').val(parseInt(newPrice) * 3);
                                $('.label-price-first').text(`${formatCash(parseInt(newPrice) * 3)}đ`);
                                $('#type-time-second').val(parseInt(newPrice) * 6);
                                $('.label-price-second').text(`${formatCash(parseInt(newPrice) * 6)}đ`);
                                $('#type-time-third').val(parseInt(newPrice) * 12);
                                $('.label-price-third').text(`${formatCash(parseInt(newPrice) * 12)}đ`);
                                // default click
                                $('#type-time-third').click();
                            }
                            $('.type-number-file').css('display', package.type == 1 ? 'none' : 'block');
                            $('.type-time').css('display', package.type == 0 ? 'none' : 'block');
                            //
                            $('.btn-open-modal-detail').click();
                        }
                    }
                })
            }

        });

        $(document).on('click', '.rdo-type-time', function() {
            let price = $(this).val();
            $('.total').text(`${formatCash(price)}đ`);
            $('.total').data('total', price);
        });

        $(document).on('click', '.btn-confirm', function() {
            let user = JSON.parse(localStorage.getItem('user'));
            $('.btn-close-modal').click();
            if (user) {
                $('.user_id').text(user.id);
            }
        });

        $(document).on('click', '.btn-complete', function() {
            let user = JSON.parse(localStorage.getItem('user'));
            if (user) {
                let total = $('.total').data('total');
                let package_id = $('#package_id').val();
                let website_id = $('#website_id').val();
                let type = $('#package_type').val();
                let expire = type == 0 ? 12 : $('input[name="type-time-option"]:checked').data('expire');
                $.ajax({
                    method: "POST",
                    url: `/api/requests/create`,
                    data: {
                        user_id: user.id,
                        package_id,
                        total,
                        expire,
                        website_id
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            toastr.success('Đăng ký thành công. Vui lòng đợi hệ thống xác nhận trong vài phút');
                        } else {
                            toastr.error(response.message);
                        }
                    }
                })
            }
        });

        function formatCash(str) {
            str = str.toString();
            if (str && str !== "0") {
                return str
                    .split("")
                    .reverse()
                    .reduce((prev, next, index) => {
                        return (index % 3 ? next : next + ".") + prev;
                    });
            }

            return str;
        }
    </script>
@endpush
@section('content')
    <div class="container" style="margin-top: 100px;">
        <div class="h-pricing-table__info h-grid" style="text-align: center;"><!--[-->
            <h2>Chọn gói hoàn hảo cho bạn</h2>
            <p class="h-pricing-table__description">Get started in complete confidence. Our 30-day money-back guarantee
                means it's risk-free.</p><!--]--><!---->
        </div>
        @foreach ($packageTypes as $type => $packages)
            <h3>{{ $type == 0 ? 'Theo số lượt tải' : 'Theo thời gian' }}</h3>
            <div class="row">
                @foreach ($packages as $package)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="item-box-blog">
                            <div class="item-box-blog-image">
                                <!--Date-->
                                @if ($package->price_sale)
                                    <div class="item-box-blog-date "
                                        style="background-color:rgb(223, 52, 52); border-radius:5px"> <span class=""
                                            style="">{{ '-' . (1 - $package->price_sale / $package->price) * 100 . '%' }}</span>
                                    </div>
                                @endif
                                <!--Image-->
                                <figure> <img alt="" src="{{ $package->avatar }}"> </figure>
                            </div>
                            <div class="item-box-blog-body">
                                <!--Heading-->
                                <div class="item-box-blog-heading">
                                    <a href="#" tabindex="0">
                                        <h5>{{ $package->name }}</h5>
                                    </a>
                                </div>
                                <!--Data-->
                                <div class="item-box-blog-data" style="padding: px 15px;">
                                    <p><i class="fa fa-user-o"></i> {{ $package->members->count() ?? 0 }} người đã và đang
                                        sử
                                        dụng
                                    </p>
                                </div>
                                <!--Text-->
                                <div class="item-box-blog-text">
                                    <p>{{ $package->description }}</p>
                                </div>
                                <div class="item-box-blog-text mb-2">
                                    <h3 class="">
                                        {{ $package->number_file . ' file/' . ($package->type == 0 ? 'năm' : 'ngày') }}</h3>
                                </div>
                                <div class="item-box-blog-text">
                                    <h3 class="price">{!! \App\Helpers\Helper::getPrice($package->price, $package->price_sale) !!}</h3>
                                </div>
                                <button style="width:100%" class="btn btn-success mt-4 btn-open-detail"
                                    data-id="{{ $package->id }}">Đăng
                                    ký</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <br>
        @endforeach
    </div>
    <input type="hidden" data-toggle="modal" data-target="#modalPackageDetail" class="btn-open-modal-detail" />
    <div class="modal fade" id="modalPackageDetail" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Lựa chọn gói</h4>
                    <button type="button" class="closeModalPackageDetail close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="package_type" />
                    <input type="hidden" id="package_id" />
                    <div class="periods type-number-file mb-2">
                        <div class="row" style="">
                            <div class="col-lg-6 col-md-6 col-sm-6">Tên gói</div>
                            <div class="col-lg-6 col-md-6 col-sm-6 package_name" style="text-align: right">aaa</div>
                        </div>
                        <div class="row" style="">
                            <div class="col-lg-6 col-md-6 col-sm-6">Số lượt tải</div>
                            <div class="col-lg-6 col-md-6 col-sm-6 package_number_file" style="text-align: right">aaa</div>
                        </div>
                    </div>
                    <div class="periods type-time row">
                        <label for="menu" style="font-weight: bold">Thời hạn <span class="required">(*)</span></label>
                        <div class="col-lg-12 col-md-12 col-sm-12 option" style="">
                            <div class=""><input class="rdo-type-time" data-expire="12" id="type-time-third" name="type-time-option"
                                    type="radio" />
                                <label for="type-time-third">1 năm</label>
                            </div>
                            <span class="btn btn-warning label-price-third" style="">120000</span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 option" style="">
                            <div class=""><input class="rdo-type-time" data-expire="6" id="type-time-second" name="type-time-option"
                                    type="radio" />
                                <label for="type-time-second">6 tháng</label>
                            </div>
                            <span class="btn btn-warning label-price-second" style="">120000</span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 option" style="">
                            <div class="">
                                <input class="rdo-type-time" id="type-time-first" data-expire="3" name="type-time-option"
                                    type="radio" />
                                <label for="type-time-first">3 tháng</label>
                            </div>
                            <span class="btn btn-warning label-price-first" style="">120000</span>
                        </div>
                    </div>
                    <div class="periods type-time row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="">
                            <div class="form-group">
                                <label for="menu" style="font-weight: bold">Website <span
                                        class="required">(*)</span></label>
                                <select name="website_id" id="website_id" class="form-control">
                                    <option selected value="ALL">--ALL--</option>
                                    @foreach ($websites as $website)
                                        <option value="{{ $website->code }}">{{ $website->code }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row block-money" style="">
                        <div class="col-lg-6 col-md-6 col-sm-6">Tổng tiền</div>
                        <div class="col-lg-6 col-md-6 col-sm-6 total" style="text-align: right"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" style="width: 100%" class="btn-close-modal btn btn-default"
                        data-dismiss="modal">Đóng</button>
                    <button type="button" style="width: 100%" class="btn-confirm btn btn-success" data-toggle="modal"
                        data-target="#modalCheckout">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalCheckout" style="display: none;" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thanh toán</h4>
                    <button type="button" class="closeModalCheckout close" data-dismiss="modal" aria-label="Close">
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
                                                aria-controls="custom-tabs-four-home" aria-selected="false">Chuyển
                                                khoản</a>
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
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 col-md-12">
                                                    <br>
                                                    <div class="clear text-center">
                                                        <div style="margin: 10px 0px 10px 0px">
                                                            <img src="/image/qr1.png">
                                                        </div>
                                                        <div>
                                                            <strong class="green">VIETINBANK</strong><br>
                                                            108868647721<br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12">
                                                    <br>
                                                    <div class="clear text-center">
                                                        <div style="margin: 10px 0px 10px 0px">
                                                            <img src="/image/qr1.png">
                                                        </div>
                                                        <div>
                                                            <strong class="green">MOMO</strong><br>
                                                            108868647721<br>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12">
                                                <br>
                                                <br>
                                                <div class="text-center">
                                                    <strong style="line-height: 30px;">Nội dung CK bắt buộc là: <span
                                                            class="orange"
                                                            style="font-size: 30px; line-height: 23px;"><span
                                                                class="user_id"></span></span></strong><br>
                                                    <em>(Trong đó <strong class="user_id"></strong> để
                                                        xác định tài
                                                        khoản của bạn, Hệ thống sẽ cộng tiền vào tài khoản này cho bạn)</em>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="bg-pop">
                                                    <ul class="introduce-list">
                                                        <li>Phải nhập chính xác nội dung CK mà hệ thống đã hiển thị sẵn cho
                                                            bạn, để được CỘNG TIỀN TỰ ĐỘNG.</li>
                                                        <li>Sau khi chuyển khoản thành công, nhấn vào nút Hoàn thành.</li>
                                                        <li>Trường hợp sau vài phút mà bạn không nhận được tiền vui lòng gọi
                                                            tới số hotline <a class="bold"
                                                                href="tel:{{ $settings['hotline'] }}"
                                                                title="Click gọi ngay!">{{ $settings['hotline'] }}</a>.
                                                        </li>
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
                    <button type="button" style="width: 100%" class="btn btn-default"
                        data-dismiss="modal">Đóng</button>
                    <button type="button" style="width: 100%" class="btn btn-success btn-complete"
                        data-dismiss="modal">Hoàn thành</button>
                </div>
            </div>
        </div>
    </div>
@endsection
