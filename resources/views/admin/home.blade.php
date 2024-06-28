@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $requests->count() }}</h3>
                    <p>Yêu cầu nạp tiền đang chờ xác nhận</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="{{ route('admin.requests.index') }}" class="small-box-footer">Xem thêm <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $websites->count() }}</h3>
                    <p>Website khả dụng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="{{ route('admin.websites.index') }}" class="small-box-footer">Xem thêm <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $users->count() }}</h3>
                    <p>Người dùng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.accounts.index') }}" class="small-box-footer">Xem thêm <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $packages->count() }}</h3>
                    <p>Gói tải đa dạng</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('admin.packages.index') }}" class="small-box-footer">Xem thêm <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $discounts->count() }}</h3>
                    <p>Mã giảm giá</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('admin.discounts.index') }}" class="small-box-footer">Xem thêm <i
                        class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ number_format((int) $total, 0, ',', '.') }} VNĐ</h3>
                    <p>Doanh thu tháng {{ date('m-Y') }}</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="{{ route('admin.reports.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>
@endsection
