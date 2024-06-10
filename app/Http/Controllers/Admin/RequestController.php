<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\User;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.request.list', [
            'title' => 'Danh sách yêu cầu nạp',
            'packages' => Package::all(),
            'websites' => Website::all(),
        ]);
    }
    public function create()
    {
        return view('admin.request.add', [
            'title' => 'Thêm yêu cầu nạp'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'price_sale' => 'nullable|numeric',
                'number_file' => 'required|numeric',
                'expire' => 'required|numeric',
                'type' => 'required|in:' . GlobalConstant::TYPE_BY_NUMBER_FILE . ',' . GlobalConstant::TYPE_BY_TIME,
                'website_id' => 'nullable|in:' . implode(',', GlobalConstant::WEB_TYPE),
                'avatar' => 'nullable|string',
                'description' => 'nullable|string',
            ]);
            Package::create($data);
            Toastr::success('Tạo yêu cầu nạp thành công', 'Thành công');
        } catch (Throwable $e) {
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => 'required|string',
                'name' => 'required|string',
                'price' => 'required|numeric',
                'price_sale' => 'nullable|numeric',
                'number_file' => 'required|numeric',
                'expire' => 'required|numeric',
                'type' => 'required|in:' . GlobalConstant::TYPE_BY_NUMBER_FILE . ',' . GlobalConstant::TYPE_BY_TIME,
                'website_id' => 'nullable|in:' . implode(',', GlobalConstant::WEB_TYPE),
                'avatar' => 'nullable|string',
                'description' => 'nullable|string',
            ]);
            DB::beginTransaction();

            unset($data['id']);
            Package::firstWhere('id', $request->id)
                ->update($data);

            DB::commit();

            Toastr::success('Cập nhật thành công', 'Thành công');
        } catch (Throwable $e) {
            DB::rollBack();
            Toastr::error($e->getMessage(), 'Lỗi');
        }

        return redirect()->back();
    }

    public function show($id)
    {
        return view('admin.request.edit', [
            'title' => 'Chi tiết yêu cầu nạp',
            'websites' => Website::all(),
            'package' => Package::firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Package::firstWhere('id', $id)
                ->delete();
            DB::commit();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}
