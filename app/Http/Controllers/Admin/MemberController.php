<?php

namespace App\Http\Controllers\Admin;

use App\Constant\GlobalConstant;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Models\Website;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;
use Toastr;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.member.list', [
            'title' => 'Danh sách thành viên',
            'members' => Member::all(),
            'websites' => Website::all(),
        ]);
    }
    public function create()
    {
        return view('admin.member.add', [
            'title' => 'Thêm thành viên'
        ]);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
                'number_file' => 'required|numeric',
                'expire' => 'required|numeric',
                'type' => 'required|in:' . GlobalConstant::TYPE_BY_NUMBER_FILE . ',' . GlobalConstant::TYPE_BY_TIME,
                'website_id' => 'nullable|in:' . implode(',', GlobalConstant::WEB_TYPE),
                'avatar' => 'nullable|string',
            ]);
            Member::create($data);
            Toastr::success('Tạo thành viên thành công', 'Thành công');
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
                'downloaded_number_file' => 'required|numeric',
                'expired_at' => 'required',
            ]);
            DB::beginTransaction();

            unset($data['id']);
            Member::firstWhere('id', $request->id)
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
        return view('admin.member.edit', [
            'title' => 'Chi tiết thành viên',
            'websites' => Website::all(),
            'member' => Member::firstWhere('id', $id),
        ]);
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            Member::firstWhere('id', $id)
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
