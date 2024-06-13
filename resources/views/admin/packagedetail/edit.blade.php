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
                        $("#avatar").val(response.url);
                    } else {
                        toastr.error(response.message, 'Thông báo');
                    }
                },
            });
        });

        $(document).on('change', '#type', function() {
            let type = $(this).val();
            console.log(type);
            $('.select-website-id').css('display', type == 0 ? 'none' : 'block');
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Cập nhật chi tiết gói</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.packagedetails.update', ['id' => $detail->id]) }}" method="POST">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="menu">Loại gói <span class="required">(*)</span></label>
                                            <select name="package_id" id="package_id" class="form-control">
                                                @foreach ($packages as $package)
                                                    <option {{$package->id == $detail->package_id ? 'selected' : ''}} value="{{ $package->id }}">{{ $package->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="menu">Giá (VNĐ)<span class="required">(*)</span></label>
                                            <input type="text" class="form-control" name="price"
                                                value="{{ old('price') ?? $detail->price }}" placeholder="Nhập giá">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="menu">Giá sale (VNĐ)</label>
                                            <input type="text" class="form-control" name="price_sale"
                                                value="{{ old('price_sale') ?? $detail->price_sale }}"
                                                placeholder="Nhập giá sale">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="menu">Số file <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" name="number_file"
                                                value="{{ old('number_file') ?? $detail->number_file }}"
                                                placeholder="Nhập số file">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="menu">Thời hạn <span class="required">(*)</span></label>
                                            <input type="text" class="form-control" name="expire"
                                                value="{{ old('expire') ?? $detail->expire }}" placeholder="Nhập thời hạn">
                                        </div>
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
