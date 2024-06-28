@extends('layout.main')
@push('styles')
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

        .btn-option {
            border: 1px solid gray;
        }
    </style>
@endpush
@push('scripts')
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
        $(document).on('click', '.btn-confirm', function() {
            let user = JSON.parse(localStorage.getItem('user'));
            $('.btn-close-modal').click();
            if (user) {
                $('.content').text(user.id + 'GD' + Date.parse(new Date()));
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

        var quantity = null;
        var time = null;
        var countApplyCode = 0;
        var clickedQuantity = null;
        var clickedTime = null;

        $(document).on('click', '.btn-option-quantity', function() {
            console.log('click quantity');
            let thisQuantity = $(this).data('quantity');

            $('.btn-option-quantity').css('border', 'none');
            $(this).css('border', '2px solid black');
            if (quantity != thisQuantity) {
                quantity = thisQuantity;
                // enable available options block-expire
                let package_id = $(this).data('package_id');
                $.ajax({
                    method: "GET",
                    url: `/api/packagedetails/searchOne?package_id=${package_id}&quantity=${thisQuantity}`,
                    success: function(response) {
                        if (response.status == 0) {
                            $('.btn-option-time').prop('disabled', true);

                            let i = 0;
                            let count = 0;
                            let firstTime = null;
                            let availableTimes = [];
                            response.detail.forEach(e => {
                                if (!availableTimes.includes(e.expire)) {
                                    availableTimes.push(e.expire);
                                }
                            });

                            availableTimes.forEach((e) => {
                                if (i == 0) {
                                    firstTime = e;
                                    i == 1;
                                }
                                $(`.btn-option-time[data-time='${e}']`).prop('disabled', false);
                            });

                            // set default time option
                            if (firstTime && !availableTimes.includes(time)) {
                                $(`.btn-option-time`).css('border',
                                    'none');
                                $(`.btn-option-time[data-time='${firstTime}']`).css('border',
                                    '2px solid black');
                                time = firstTime;
                            }
                            getPrice(package_id, quantity, time);
                        } else {
                            // to do
                        }
                    }
                });
            } else {
                quantity = null;
                $(this).css('border', 'none');
                $('.btn-option-time').prop('disabled', false);
            }
        });

        $(document).on('click', '.btn-option-time', function() {
            let thisTime = $(this).data('time');

            $('.btn-option-time').css('border', 'none');
            $(this).css('border', '2px solid black');
            if (time != thisTime) {
                time = thisTime;
                // enable available options block-expire
                let package_id = $(this).data('package_id');
                $.ajax({
                    method: "GET",
                    url: `/api/packagedetails/searchOne?package_id=${package_id}&time=${thisTime}`,
                    success: function(response) {
                        if (response.status == 0) {
                            $('.btn-option-quantity').prop('disabled', true);

                            let i = 0;
                            let count = 0;
                            let firstQuantity = null;
                            let availableQuantities = [];
                            response.detail.forEach(e => {
                                if (!availableQuantities.includes(e.number_file)) {
                                    availableQuantities.push(e.number_file);
                                }
                                $(`.btn-option-quantity[data-package_id='${package_id}']`).each(
                                    function() {
                                        if ($(this).data('quantity') == e.number_file) {
                                            if (i == 0) {
                                                i == 1;
                                                firstQuantity = e.number_file;
                                            }
                                            if (quantity == e.number_file) {
                                                count == 1;
                                            }
                                            $(this).prop('disabled', false);
                                        }
                                    });
                            });
                            availableQuantities.forEach((e) => {
                                if (i == 0) {
                                    firstQuantity = e;
                                    i == 1;
                                }
                                $(`.btn-option-quantity[data-quantity='${e}']`).prop('disabled',
                                    false);
                            });
                            // set default quantity option
                            if (firstQuantity && !availableQuantities.includes(quantity)) {
                                $(`.btn-option-quantity`).css('border',
                                    'none');
                                $(`.btn-option-quantity[data-quantity='${firstQuantity}']`).css(
                                    'border',
                                    '2px solid black');
                                quantity = firstQuantity;
                            }
                            getPrice(package_id, quantity, time);

                        } else {
                            // to do
                        }
                    }
                });
            } else {
                time = null;
                $(this).css('border', 'none');
                $('.btn-option-quantity').prop('disabled', false);
            }
        });

        $(document).on('click', '.btn-complete', function() {
            let user = JSON.parse(localStorage.getItem('user'));
            if (user) {
                let total = $('.price').data('price');
                let packagedetail_id = $('#packagedetail_id').val();
                let type = $('#package_type').val();
                let website_id = type == 0 ? '' : $('#website_id').val();
                let expire = time;
                let content = $('#content').text();

                $.ajax({
                    method: "POST",
                    url: `/api/requests/create`,
                    data: {
                        user_id: user.id,
                        packagedetail_id,
                        total,
                        expire,
                        website_id,
                        content
                    },
                    success: function(response) {
                        if (response.status == 0) {
                            toastr.success(
                                'Đăng ký thành công. Vui lòng đợi hệ thống xác nhận trong vài phút');
                        } else {
                            toastr.error(response.message);
                        }
                    }
                });
            } else {
                toastr.error('Bạn cần đăng nhập');
                $('.btn-open-login').click();
            }
        });

        $(document).on('click', '.btn-buy', function() {
            if (!quantity || !time) {
                toastr.error('Chưa chọn thông tin gói');
                return;
            }

            let user = JSON.parse(localStorage.getItem('user'));
            if (!user) {
                toastr.error('Bạn cần đăng nhập');
                $('.btn-open-login').click();
                return;
            }

            if (!$('.price').data('price')) {
                toastr.error('Gói không khả dụng');
                return;
            }

            $('.content').text(user.id + 'GD' + Date.parse(new Date()));
            $('.btn-open-modal-checkout').click();
        });

        $(document).on('change', '.discount-code', function() {
            let package_id = $(this).data('package_id');
            countApplyCode = 0;

            getPrice(package_id, quantity, time);

        })

        $(document).on('click', '.btn-apply-code', function() {
            if (countApplyCode == 1) {
                toastr.error('Đã nhập mã giảm giá');
                return;
            }
            if (!quantity || !time) {
                toastr.error('Chưa chọn thông tin gói');
                return;
            }

            if (!$('.price').data('price')) {
                toastr.error('Gói không khả dụng');
                return;
            }

            let user = JSON.parse(localStorage.getItem('user'));
            if (!user) {
                toastr.error('Bạn cần đăng nhập');
                $('.btn-open-login').click();
                return;
            }

            let discountCode = $('.discount-code').val();
            if (!discountCode) {
                toastr.error('Bạn cần nhập mã giảm giá');
                return;
            }

            $.ajax({
                method: "GET",
                url: `/api/discounts/getDiscountByCode?code=${discountCode}`,
                success: function(response) {
                    if (response.status == 0) {
                        let oldPrice = $('.price').data('price');
                        let discount = response.discount.discount;
                        let newPrice = parseInt((1 - discount / 100) * oldPrice);

                        $('.price').data('price', newPrice);
                        $('.price').text(
                            `${formatCash(newPrice)} đ`);

                        toastr.success(`Áp mã thành công. Quý khách được giảm ${discount}%`);
                        // prevent apply code more
                        countApplyCode = 1;
                    } else {
                        toastr.error(response.message);
                    }
                }
            });
        });

        function getPrice(package_id, quantity = '', time = '') {
            $.ajax({
                method: "GET",
                url: `/api/packagedetails/searchOne?package_id=${package_id}&quantity=${quantity}&time=${time}&limit=${1}`,
                success: function(response) {
                    if (response.status == 0) {
                        let detail = response.detail[0];
                        if (detail) {
                            $('.price').text(
                                `${formatCash(detail.price_sale || detail.price)} đ`);
                            $('.price').data('price', detail.price_sale || detail.price);
                            $('#packagedetail_id').val(detail.id);
                            // $('.status').text(`Còn hàng`);
                            $('.status').css('color', 'green');
                        }
                    } else {
                        $('.price').data('price', '');
                        // $('.status').text(`Gói không khả dụng`);
                        $('.status').css('color', 'red');
                    }
                }
            });
        }
    </script>
@endpush
@section('content')
    <div class="main-content" style="margin-top: 100px;">
        <div class="h-pricing-table__info h-grid mb-4" style="text-align: center;"><!--[-->
            <h2 style="font-weight: bold">Chọn gói hoàn hảo cho bạn</h2>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="">
                    <img src="{{ $package->avatar }}" style="width: 100%;height:100%" alt="{{ $package->avatar }}" />
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="uk-panel tm-element-woo-title" id="template-ASly7_2n#3">
                    <h1 class="product_title entry-title">{{ $package->name }}</h1>
                    <div class="wp_rv_product_info">
                        <span class="wp_rv_sold"><strong>{{ rand(300, 600) }}</strong> Đã bán</span>
                    </div>
                    <h3 class="price">
                        {{ number_format($prices[0], 0) . ' đ ~' . number_format($prices[count($prices) - 1], 0) . ' đ' }}
                    </h3>
                    <h5 class="status">
                    </h5>
                    <div class="">
                        <label for="">Số lượng</label>
                        <div class="block-quantity">
                            @php
                                $typeText =
                                    $package->type == \App\Constant\GlobalConstant::TYPE_BY_TIME ? 'Ngày' : 'Năm';
                            @endphp
                            @foreach ($quantities as $quantity)
                                <button data-package_id="{{ $package->id }}" data-quantity="{{ $quantity }}"
                                    class="btn btn-option btn-option-quantity btn-default btn-sm">{{ $quantity }}
                                    File/{{ $typeText }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-2">
                        <label for="">Thời gian</label>
                        <div class="block-expire">
                            @foreach ($times as $time)
                                <button data-package_id="{{ $package->id }}" data-time="{{ $time }}"
                                    class="btn btn-option btn-option-time btn-default btn-sm">{{ $time }}
                                    tháng</button>
                            @endforeach
                        </div>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-success btn-buy">MUA NGAY</button>
                    </div>
                    <div class="">
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                <input data-package_id="{{ $package->id }}" type="text"
                                    class="form-control discount-code" placeholder="Nhập mã giảm giá..." />
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 mt-2">
                                <button style="" class="btn btn-warning btn-apply-code">ÁP MÃ</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" data-toggle="modal" data-target="#modalCheckout" class="btn-open-modal-checkout" />
    <input type="hidden" id="package_id" value="{{ $package->id }}" />
    <input type="hidden" id="packagedetail_id" />
    <input type="hidden" id="package_type" value="{{ $package->type }}" />
    <input type="hidden" id="website_id" value="{{ $package->website_id }}" />
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
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="custom-tabs-four-tabContent">
                                        <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel"
                                            aria-labelledby="custom-tabs-four-home-tab">
                                            <div class="text-center">
                                                Bạn vui lòng CK số tiền <b class="price"></b> bằng cách quét mã QR của 1
                                                trong 2 ngân
                                                hàng sau:
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 col-sm-12 col-md-12">
                                                    <br>
                                                    <div class="clear text-center">
                                                        <div style="margin: 10px 0px 10px 0px">
                                                            <img style="width: 350px;height:350px" src="{{ $settings['qr-checkout-1'] }}">
                                                        </div>
                                                        <div>
                                                            <strong class="green">{{ $settings['qr-bank-name-1'] }}</strong><br>
                                                            {{ $settings['qr-account-1'] }}<br>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-md-12">
                                                    <br>
                                                    <div class="clear text-center">
                                                        <div style="margin: 10px 0px 10px 0px">
                                                            <img style="width: 350px;height:350px" src="{{ $settings['qr-checkout-2'] }}">
                                                        </div>
                                                        <div>
                                                            <strong class="green">{{ $settings['qr-bank-name-2'] }}</strong><br>
                                                            {{ $settings['qr-account-2'] }}<br>
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
                                                                class="content" id="content"></span></span></strong><br>
                                                    <em>(Trong đó <strong class="content"></strong> để
                                                        xác định tài
                                                        khoản của bạn, Hệ thống sẽ đăng ký gói vào tài khoản này cho
                                                        bạn)</em>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-xs-12">
                                                <div class="bg-pop">
                                                    <ul class="introduce-list">
                                                        <li>Phải nhập chính xác nội dung CK mà hệ thống đã hiển thị sẵn cho
                                                            bạn, để được ĐĂNG KÝ TỰ ĐỘNG.</li>
                                                        <li>Sau khi chuyển khoản thành công, nhấn vào nút Hoàn thành.</li>
                                                        <li>Trường hợp sau vài phút mà bạn không nhận được gói vui lòng gọi
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
