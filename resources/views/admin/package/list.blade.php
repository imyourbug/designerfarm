@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
    <script src="/js/ckeditor/ckeditor.js"></script>
@endpush
@push('scripts')
    <script src="/js/admin/package/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        CKEDITOR.replace('description');

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
                    <form action="{{ route('admin.packages.store') }}" method="POST">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Tên gói <span class="required">(*)</span></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name') }}" placeholder="Nhập tên gói">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 select-type">
                                    <div class="form-group">
                                        <label for="menu">Loại gói <span class="required">(*)</span></label>
                                        <select name="type" id="type" class="form-control">
                                            <option value="0">Tải lẻ</option>
                                            <option value="1">Tải file theo tháng và năm</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="menu">Mô tả</label>
                                        <textarea class="form-control" placeholder="Nhập mô tả" name="description" id="description" cols="30" rows="5">{{ old('description') ?? 'Gói nhiều ưu đãi' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 select-website-id" style="display: none">
                                    <div class="form-group">
                                        <label for="menu">Website <span class="required">(*)</span></label>
                                        <select name="website_id" id="website_id" class="form-control">
                                            <option selected value="">--Không--</option>
                                            {{-- <option value="ALL">--ALL--</option>  --}}
                                            @foreach ($websites as $website)
                                                <option value="{{ $website->code }}">{{ $website->code }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="file">Ảnh hiển thị</label><br>
                                        <div class="">
                                            <img id="image_show" style="width: 100px;height:100px" src=""
                                                alt="Avatar" />
                                            <input type="file" id="upload" accept=".png,.jpeg">
                                        </div>
                                        <input type="hidden" name="avatar" id="avatar" value="{{ old('avatar') }}">
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
    <div class="row">
        <div class="col-lg-12">
            <div class="card direct-chat direct-chat-primary">
                <div class="card-header ui-sortable-handle header-color" style="cursor: move;">
                    <h3 class="card-title text-bold">Danh sách gói</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body" style="display: block;padding: 10px !important;">
                    <table id="table" class="table display nowrap dataTable dtr-inline collapsed">
                        <thead>
                            <tr>
                                <th>Tên gói</th>
                                {{-- <th>Giá (VNĐ)</th>
                                <th>Giá sale (VNĐ)</th>
                                <th>Số file</th>
                                <th>Thời hạn (tháng)</th> --}}
                                <th>Loại gói</th>
                                <th>Website</th>
                                <th>Mô tả</th>
                                <th>Ảnh</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
