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
                <h3 class="card-title text-bold">Cập nhật key</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: block;padding: 10px !important;">
                <form action="{{ route('admin.keys.update', ['id' => $key->id]) }}" method="POST">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label for="menu">Loại key <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="type" value="{{ $key->type }}"
                                        placeholder="Nhập loại key">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 select-type">
                                <div class="form-group">
                                    <label for="menu">App ID <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="app_id" value="{{ $key->app_id }}"
                                        placeholder="Nhập key">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 select-type">
                                <div class="form-group">
                                    <label for="menu">App key <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="app_key" value="{{ $key->app_key }}"
                                        placeholder="Nhập key">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12 select-type">
                                <div class="form-group">
                                    <label for="menu">App secret <span class="required">(*)</span></label>
                                    <input type="text" class="form-control" name="app_secret" value="{{ $key->app_secret }}"
                                        placeholder="Nhập key">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group">
                                    <label>Trạng thái<span class="required">(*)</span></label>
                                    <select name="status" class="form-control" id="">
                                        <option value="1" {{ $key->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $key->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Lưu</button>
                    </div>
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection