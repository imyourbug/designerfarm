@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Cập nhật mã giảm giá</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.discounts.update', ['id' => $discount->id]) }}" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Mã giảm giá <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="code"
                                            value="{{ old('code') ?? $discount->code }}" placeholder="Nhập mã giảm giá">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">% giảm <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="discount"
                                            value="{{ old('discount') ?? $discount->discount }}" placeholder="Nhập % giảm">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('admin.discounts.index') }}" class="btn btn-success">Danh sách mã giảm giá</a>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
