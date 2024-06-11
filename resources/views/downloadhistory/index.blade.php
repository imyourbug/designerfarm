@extends('layout.main')
@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/css/package/index.css" rel="stylesheet">
@endpush
@push('scripts')
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
@endpush
@section('content')
    <div class="container" style="margin-top: 100px;">
        <div class="h-pricing-table__info h-grid" style="text-align: center;"><!--[-->
            <h2>Lịch sử tải xuống</h2>
        </div>
        <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
            <thead>
                <tr>
                    <th>Tài khoản</th>
                    <th>Nội dung CK</th>
                    <th>Tên gói</th>
                    <th>Tổng tiền (VNĐ)</th>
                    <th>Thời hạn (tháng)</th>
                    <th>Loại gói</th>
                    <th>Website</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
