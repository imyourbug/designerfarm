<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Package;
use App\Models\PackageDetail;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class PackageDetailController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.packagedetail.list', [
            'title' => 'Danh sách chi tiết gói',
            'packages' => Package::all(),
            'websites' => Website::all(),
        ]);
    }
    public function create()
    {
        return view('admin.packagedetail.add', [
            'title' => 'Thêm chi tiết gói'
        ]);
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $data = $request->validate([
                'price' => 'required|numeric',
                'price_sale' => 'nullable|numeric',
                'number_file' => 'required|numeric',
                'expire' => 'required|numeric',
                'package_id' => 'required|numeric',
            ]);
            PackageDetail::create($data);
            Toastr::success('Tạo chi tiết gói thành công', 'Thành công');
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
                'price' => 'required|numeric',
                'price_sale' => 'nullable|numeric',
                'number_file' => 'required|numeric',
                'expire' => 'required|numeric',
                'package_id' => 'required|numeric',
            ]);
            DB::beginTransaction();

            // check
            $package = PackageDetail::where([
                'number_file' => $data['number_file'],
                'expire' => $data['expire'],
                'package_id' => $data['package_id'],
            ])
                ->first();
            if ($package) {
                throw new Exception('Đã tồn tại');
            }

            unset($data['id']);
            PackageDetail::firstWhere('id', $request->id)
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
        return view('admin.packagedetail.edit', [
            'title' => 'Chi tiết gói',
            'packages' => Package::all(),
            'detail' => PackageDetail::firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            PackageDetail::firstWhere('id', $id)
                ->delete();
            Member::where('packagedetail_id', $id)
                ->delete();
            ModelsRequest::where('packagedetail_id', $id)
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
