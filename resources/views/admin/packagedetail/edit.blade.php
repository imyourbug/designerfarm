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
                    <h3 class="card-title text-bold">Thêm gói</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <form action="{{ route('admin.packages.update', ['id' => $package->id]) }}" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Tên gói <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') ?? $package->name }}" placeholder="Nhập tên gói">
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Giá (VNĐ) <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="price"
                                            value="{{ old('price') ?? $package->price }}" placeholder="Nhập giá">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Giá sale (VNĐ)</label>
                                        <input type="text" class="form-control" name="price_sale"
                                            value="{{ old('price_sale') ?? $package->price_sale }}"
                                            placeholder="Nhập giá sale">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Số file <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="number_file"
                                            value="{{ old('number_file') ?? $package->number_file }}"
                                            placeholder="Nhập số file">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Thời hạn <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="expire"
                                            value="{{ old('expire') ?? $package->expire }}" placeholder="Nhập thời hạn">
                                    </div>
                                </div> --}}
                                <div class="col-lg-6 col-sm-12 select-type">
                                    <div class="form-group">
                                        <label for="menu">Loại gói <span class="required">(*)</span></label>
                                        <select name="type" id="type" class="form-control">
                                            <option {{ $package->type == 0 ? 'selected' : '' }} value="0">Tải lẻ
                                            </option>
                                            <option {{ $package->type == 1 ? 'selected' : '' }} value="1">Tải file theo
                                                tháng và năm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 select-website-id" style="display: {{$package->type == 0 ? 'none' : 'block'}}">
                                    <div class="form-group">
                                        <label for="menu">Website <span class="required">(*)</span></label>
                                        <select name="website_id" id="website_id" class="form-control">
                                            {{-- <option selected value="">--Không--</option> --}}
                                            {{-- <option {{ $package->website_id == 'ALL' ? 'selected' : '' }} value="ALL">
                                                --ALL--</option> --}}
                                            @foreach ($websites as $website)
                                                <option {{ $package->website_id == $website->code ? 'selected' : '' }}
                                                    value="{{ $website->code }}">{{ $website->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Mô tả</label>
                                        <textarea class="form-control" placeholder="Nhập mô tả" name="description" id="description" cols="30"
                                            rows="5">{{ old('description') ?? $package->description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="file">Ảnh hiển thị</label><br>
                                        <div class="">
                                            <img id="image_show" style="width: 100px;height:100px"
                                                src="{{ old('avatar') ?? $package->avatar }}" alt="Avatar" />
                                            <input type="file" id="upload" accept=".png,.jpeg">
                                        </div>
                                        <input type="hidden" name="avatar" id="avatar"
                                            value="{{ old('avatar') ?? $package->avatar }}">
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
