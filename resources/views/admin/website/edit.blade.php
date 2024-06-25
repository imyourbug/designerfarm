@extends('admin.main')
@push('styles')
@endpush
@push('scripts')
    <script>
        $(document).on('change', '#upload', function() {
            const form = new FormData();
            form.append("file", $(this)[0].files[0]);
            console.log(form);
            $.ajax({
                processData: false,
                contentType: false,
                type: "POST",
                data: form,
                url: "/api/upload",
                success: function(response) {
                    if (response.status == 0) {
                        //hiển thị ảnh
                        $("#image_show").attr('src', response.url);
                        $("#image").val(response.url);
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Cập nhật website</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.websites.update', ['id' => $website->id]) }}" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Tên website <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') ?? $website->name }}" placeholder="Nhập tên website">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Mã website <span class="required">(*)</span></label>
                                        <input readonly type="text" class="form-control" name="code"
                                            value="{{ old('code') ?? $website->code }}" placeholder="Nhập mã website">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Link mẫu <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="sample_link"
                                            value="{{ old('sample_link') ?? $website->sample_link }}"
                                            placeholder="Nhập link mẫu">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Link website <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="website_link"
                                            value="{{ old('website_link') ?? $website->website_link }}"
                                            placeholder="Nhập link website">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Trạng thái <span class="required">(*)</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option {{ $website->status == 0 ? 'selected' : '' }} value="0">Bảo trì
                                            </option>
                                            <option {{ $website->status == 1 ? 'selected' : '' }} value="1">Hoạt động
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="is_download_by_retail">Bao gồm tải lẻ <span
                                                class="required">(*)</span></label>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio" id="is_download_by_retail"
                                                value="1" name="is_download_by_retail"
                                                {{ $website->is_download_by_retail == 1 ? 'checked' : '' }}>
                                            <label for="is_download_by_retail" class="custom-control-label">Có</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input class="custom-control-input" type="radio"
                                                id="is_not_download_by_retail" value="0" name="is_download_by_retail"
                                                {{ $website->is_download_by_retail == 0 ? 'checked' : '' }}>
                                            <label for="is_not_download_by_retail"
                                                class="custom-control-label">Không</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="file">Ảnh hiển thị</label><br>
                                        <div class="">
                                            <img id="image_show" style="width: 100px;height:100px"
                                                src="{{ $website->image }}" alt="Avatar" />
                                            <input type="file" id="upload" accept=".png,.jpeg">
                                        </div>
                                        <input type="hidden" name="image" id="image"
                                            value="{{ old('image') ?? $website->image }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Lưu</button>
                            <a href="{{ route('admin.websites.index') }}" class="btn btn-success">Danh sách website</a>
                        </div>
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
