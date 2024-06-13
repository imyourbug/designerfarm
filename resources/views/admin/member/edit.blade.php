@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endpush
@push('scripts')
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Cập nhật thành viên</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.members.update', ['id' => $member->id]) }}" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Số lượt đã tải<span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="downloaded_number_file"
                                            value="{{ old('downloaded_number_file') ?? $member->downloaded_number_file }}"
                                            placeholder="Nhập số lượt đã tải">
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Số file <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="number_file"
                                            value="{{ old('number_file') ?? $member->number_file }}"
                                            placeholder="Nhập số file">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Ngày hết hạn <span class="required">(*)</span></label>
                                        <input type="datetime-local" class="form-control" name="expired_at"
                                            value="{{ old('expired_at') ?? $member->expired_at }}"
                                            placeholder="Nhập ngày hết hạn">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('admin.members.index') }}" class="btn btn-success">Danh sách thành viên</a>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
