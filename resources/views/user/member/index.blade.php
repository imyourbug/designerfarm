@extends('layout.main')
@push('styles')
    <link href="/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="/css/package/index.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endpush
@push('scripts')
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="/js/user/member/index.js"></script>
@endpush
@section('content')
    <div class="main-content" style="margin-top: 100px;">
        <div class="h-pricing-table__info h-grid" style="text-align: center;"><!--[-->
            <h2>{{ $title }}</h2>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card direct-chat direct-chat-primary">
                    <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                        <h3 class="card-title text-bold">{{ $title }}</h3>
                    </div>
                    <div class="card-body" style="display: block;padding: 10px !important;">
                        <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                            <thead>
                                <tr>
                                    {{-- <th>Tài khoản</th> --}}
                                    <th>Tên gói</th>
                                    <th>Số lượt tải</th>
                                    <th>Số lượt tải còn lại</th>
                                    <th>Thời hạn (tháng)</th>
                                    <th>Ngày hết hạn</th>
                                    <th>Loại gói</th>
                                    <th>Website</th>
                                    {{-- <th>Thao tác</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
