@extends('admin.main')
@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.0.1/css/buttons.dataTables.css">
@endpush
@push('scripts')
    <script src="/js/admin/account/index.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
@endpush
@section('content')
    <form action="{{ route('admin.accounts.update', ['id' => $user->id]) }}" method="POST">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label for="menu">Tài khoản <span class="required">(*)</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}"
                            placeholder="Nhập tài khoản" disabled>
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label for="menu">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password"
                            value="{{ old('password') }}" placeholder="Nhập mật khẩu">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Phân quyền<span class="required">(*)</span></label>
                        <select name="role" class="form-control" id="">
                            <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Admin</option>
                            <option {{ $user->role == 0 ? 'selected' : '' }} value="0">Người dùng</option>
                        </select>
                    </div>
                </div>
            </div>
            <input type="hidden" name="user_id" value="{{ request()->id }}" />
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('admin.accounts.index') }}" class="btn btn-success">Xem danh sách</a>
        </div>
        @csrf
    </form>
@endsection
