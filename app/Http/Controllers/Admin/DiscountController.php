<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Models\Member;
use App\Models\Package;
use App\Models\Request as ModelsRequest;
use App\Models\User;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.discount.list', [
            'title' => 'Danh sách mã giảm giá',
            'discounts' => Discount::all(),
        ]);
    }
    public function create()
    {
        return view('admin.discount.add', [
            'title' => 'Thêm mã giảm giá'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'code' => 'required|string',
                'discount' => 'required|numeric',
            ]);
            Discount::create($data);
            Toastr::success('Tạo mã giảm giá thành công', 'Thành công');
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
                'code' => 'required|string',
                'discount' => 'required|numeric',
            ]);
            DB::beginTransaction();

            unset($data['id']);
            Discount::firstWhere('id', $request->id)
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
        return view('admin.discount.edit', [
            'title' => 'Chi tiết mã giảm giá',
            'discount' => Discount::firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            Discount::firstWhere('id', $id)
                ->delete();

            return response()->json([
                'status' => 0,
            ]);
        } catch (Throwable $e) {

            return response()->json([
                'status' => 1,
                'message' => $e->getMessage()
            ]);
        }
    }
}
