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
                                    <figure>
                                        <img alt="image" src="{{ $package->avatar }}" />
                                    </figure>
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
                                    <div class="item-box-blog-text">
                                        <p>{{ $package->description }}</p>
                                    </div>
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
@endsection
