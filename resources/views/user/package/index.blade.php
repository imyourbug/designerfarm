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
    </style>
@endpush
@push('scripts')
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script>
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
    <div class="main-content" style="margin-top: 100px;">
        <div class="h-pricing-table__info h-grid mb-4" style="text-align: center;"><!--[-->
            <h2 style="font-weight: bold">Chọn gói hoàn hảo cho bạn</h2>
        </div>
        <br>
        <br>
        @foreach ($packageTypes as $type => $packages)
            <h3>{{ $type == 0 ? 'Theo số lượt tải' : 'Theo thời gian' }}</h3>
            <div class="row">
                @foreach ($packages as $package)
                    @if ($package->details->count())
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="item-box-blog">
                                <div class="item-box-blog-image">
                                    <!--Date-->
                                    @if ($package->price_sale)
                                        <div class="item-box-blog-date "
                                            style="background-color:rgb(223, 52, 52); border-radius:5px"> <span
                                                class=""
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
                                        <p><i class="fa fa-user-o"></i> {{ rand(100, 500) }} người đã và
                                            đang
                                            sử
                                            dụng
                                        </p>
                                    </div>
                                    <!--Text-->
                                    <div class="item-box-blog-text">
                                        <p>{{ $package->description }}</p>
                                    </div>
                                    {{-- <div class="item-box-blog-text mb-2">
                                        <h3 class="">
                                            {{ $package->number_file . ' file/' . ($package->type == 0 ? 'năm' : 'ngày') }}
                                        </h3>
                                    </div>
                                    <div class="item-box-blog-text">
                                        <h3 class="price">{!! \App\Helpers\Helper::getPrice($package->price, $package->price_sale) !!}</h3>
                                    </div> --}}
                                    <a style="width:100%" class="btn btn-success mt-4 btn-open-detail"
                                        href="{{ route('packages.show', ['id' => $package->id]) }}">Đăng
                                        ký</a>
                                </div>
                            </div>
                        </div>
                    @endif
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
                            <div class=""><input class="rdo-type-time" data-expire="12" id="type-time-fourth"
                                    name="type-time-option" type="radio" />
                                <label for="type-time-fourth">1 năm</label>
                            </div>
                            <span class="btn btn-warning label-price-fourth" style="">120000</span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 option" style="">
                            <div class=""><input class="rdo-type-time" data-expire="6" id="type-time-third"
                                    name="type-time-option" type="radio" />
                                <label for="type-time-third">6 tháng</label>
                            </div>
                            <span class="btn btn-warning label-price-third" style="">120000</span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 option" style="">
                            <div class="">
                                <input class="rdo-type-time" id="type-time-second" data-expire="3" name="type-time-option"
                                    type="radio" />
                                <label for="type-time-second">3 tháng</label>
                            </div>
                            <span class="btn btn-warning label-price-second" style="">120000</span>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 option" style="">
                            <div class="">
                                <input class="rdo-type-time" id="type-time-first" data-expire="1"
                                    name="type-time-option" type="radio" />
                                <label for="type-time-first">1 tháng</label>
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
@endsection
